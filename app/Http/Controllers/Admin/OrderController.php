<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class OrderController extends BaseController
{
    public function index(Request $req)
    {
        $customerEmail = $req->query('customer_email');
        $status = $req->query('status');
        $limit = min((int)($req->query('limit', 50)), 200);
        $where = [];$params = [];
        if ($customerEmail) { $where[] = 'customer_email = ?'; $params[] = (string)$customerEmail; }
        if ($status) { $where[] = 'status = ?'; $params[] = (string)$status; }
        $whereSql = $where ? ('WHERE '.implode(' AND ',$where)) : '';
        try {
            $rows = DB::select("SELECT * FROM orders $whereSql ORDER BY id DESC LIMIT $limit", $params);
            return response()->json(['success'=>true,'data'=>$rows]);
        } catch (\Throwable $e) {
            return response()->json(['success'=>true,'data'=>[]]);
        }
    }

    public function update(Request $req, $id)
    {
        $orderId = (int)$id;
        $newStatus = $req->input('status');
        if (!$newStatus) {
            return response()->json(['success' => false, 'message' => 'Status required'], 400);
        }

        try {
            $updated = DB::update('UPDATE orders SET status = ? WHERE id = ?', [$newStatus, $orderId]);
            if ($updated === 0) {
                return response()->json(['success' => false, 'message' => 'Order not found'], 404);
            }
            return response()->json(['success' => true, 'message' => 'Status updated']);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status'], 500);
        }
    }

    public function receipt($id)
    {
        $orderId = (int)$id;
        if ($orderId <= 0) {
            return response()->json(['success' => false, 'message' => 'Invalid order ID'], 400);
        }

        $order = DB::table('orders')
            ->where('id', $orderId)
            ->orWhereRaw('CAST(id AS UNSIGNED) = ?', [$orderId])
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
        }

        $items = DB::table('order_items')
            ->where('order_id', $orderId)
            ->orWhereRaw('CAST(order_id AS UNSIGNED) = ?', [$orderId])
            ->get();

        // Render Blade view as HTML
        $html = View::make('receipt', compact('order', 'items'))->render();
        return response($html)->header('Content-Type', 'text/html');
    }

    public function destroy(Request $req, $id)
    {
        try {
            $orderId = (int)$id;
            if ($orderId <= 0) {
                return response()->json(['success' => false, 'message' => 'Invalid order ID'], 400);
            }

            $deleted = DB::delete('DELETE FROM orders WHERE id = ? LIMIT 1', [$orderId]);
            if ($deleted === 0) {
                return response()->json(['success' => false, 'message' => 'Order not found'], 404);
            }

            return response()->json(['success' => true, 'message' => 'Order deleted successfully']);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete order'], 500);
        }
    }
}