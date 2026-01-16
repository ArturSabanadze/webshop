<?php

class UserOrders
{
    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get all order IDs for the current user
     */
    public function getUserOrderIds(PDO $db): array
    {
        $stmt = $db->prepare(
            "SELECT id 
             FROM orders 
             WHERE user_id = :user_id"
        );

        $stmt->bindValue(':user_id', $this->userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Get order items with product and optional seminar data
     */
    public function getOrderItemsWithSeminars(PDO $db): array
    {
        $sql = "
        SELECT 
            oi.*,
            p.title AS product_title,
            ls.id AS seminar_id,
            ls.start_date,
            ls.end_date,
            se.id AS seminar_participation_id
        FROM orders o
        JOIN order_items oi 
            ON oi.order_id = o.id
        JOIN products p 
            ON oi.product_id = p.id
        LEFT JOIN live_seminars ls 
            ON ls.product_id = oi.product_id
        LEFT JOIN seminar_participants se 
            ON se.seminar_id = ls.id
           AND se.user_id = :user_id
        WHERE o.user_id = :user_id
          AND (ls.id IS NULL OR se.id IS NOT NULL)
        ORDER BY o.id DESC, oi.id ASC
    ";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $this->userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
