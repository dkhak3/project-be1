<?php
class ProductModel extends Model
{
    public function getAllProducts()
    {
        $sql = parent::$connection->prepare('SELECT * FROM products');
        return parent::select($sql);
    }

    public function addProduct($product_name, $product_description, $product_price, $product_photo)
    {
        $sql = parent::$connection->prepare('INSERT INTO `products`(`product_name`, `product_description`, `product_price`, `product_photo`) VALUES (?, ?, ?, ?)');
        $sql->bind_param('ssis', $product_name, $product_description, $product_price, $product_photo);
        return $sql->execute();
    }

    public function editProduct($product_name, $product_description, $product_price, $product_photo, $id)
    {
        if ($product_photo != '') {
            $sql = parent::$connection->prepare('UPDATE `products` SET `product_name` =?, `product_description` =?, `product_price` =?, `product_photo` =? WHERE `id` =?');
            $sql->bind_param('ssisi', $product_name, $product_description, $product_price, $product_photo, $id);
            return $sql->execute();
        } else {
            $sql = parent::$connection->prepare('UPDATE `products` SET `product_name` =?, `product_description` =?, `product_price` =? WHERE `id` =?');
            $sql->bind_param('ssii', $product_name, $product_description, $product_price, $id);
            return $sql->execute();
        }
    }

    public function deleteProduct($id)
    {
        $sql = parent::$connection->prepare('DELETE FROM `products` WHERE `id` =?');
        $sql->bind_param('i', $id);
        return $sql->execute();
    }

    public function getProductById($id)
    {
        $sql = parent::$connection->prepare('SELECT *, COUNT(user_product_like.username) AS pLike FROM `products` LEFT JOIN user_product_like ON products.id = user_product_like.product_id WHERE products.id = ? GROUP BY products.id;');
        $sql->bind_param('i', $id);
        return parent::select($sql)[0];
    }

    public function getProductByCategory($id)
    {
        $sql = parent::$connection->prepare('SELECT * FROM products INNER JOIN products_categories ON products.id = products_categories.product_id WHERE category_id=?');
        $sql->bind_param('i', $id);
        return parent::select($sql);
    }

    public function getProductsByKeyword($nameFind)
    {
        $sql = parent::$connection->prepare('SELECT * FROM products WHERE product_name like ?');
        $nameFind = "%{$nameFind}%";
        $sql->bind_param('s', $nameFind);
        return parent::select($sql);
    }

    public function getIdProductByProductName($productName)
    {
        $sql = parent::$connection->prepare('SELECT id FROM products WHERE product_name = ?');
        $sql->bind_param('s', $productName);
        return parent::select($sql)[0]['id'];
    }

    public function getProductByIds($arrId)
    {
        $chamHoi = str_repeat('?,', count($arrId) - 1);
        $chamHoi .= '?';
        $i = str_repeat('i', count($arrId));
        $sql = parent::$connection->prepare("SELECT * FROM products WHERE id IN ( $chamHoi ) ORDER BY FIELD(id, $chamHoi) DESC LIMIT 0, 5");
        $sql->bind_param($i . $i, ...$arrId, ...$arrId);
        return parent::select($sql);
    }

    public function getProductsByPage($page, $perpage)
    {
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare('SELECT * FROM products LIMIT ?, ?;');
        $sql->bind_param('ii', $start, $perpage);
        return parent::select($sql);
    }

    public function getProductsFindByPage($page, $perpage, $nameFind)
    {
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare('SELECT * FROM products WHERE product_name LIKE ? LIMIT ?, ?;');
        $nameFind = "%{$nameFind}%";
        $sql->bind_param('sii', $nameFind, $start, $perpage);
        return parent::select($sql);
    }

    public function getProductInCategoryByPage($page, $perpage, $id)
    {
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare('SELECT * FROM products INNER JOIN products_categories ON products.id = products_categories.product_id WHERE category_id=? LIMIT ?, ?;');
        $sql->bind_param('iii', $id, $start, $perpage);
        return parent::select($sql);
    }

    public function getTotalProduct()
    {
        $sql = parent::$connection->prepare('SELECT count(id) as total_product FROM products');
        return parent::select($sql)[0]['total_product'];
    }

    public function getTotalProductFind($nameFind)
    {
        $sql = parent::$connection->prepare('SELECT count(id) as total_product_find FROM products WHERE product_name like ?');
        $nameFind = "%{$nameFind}%";
        $sql->bind_param('s', $nameFind);
        return parent::select($sql)[0]['total_product_find'];
    }

    public function getTotalProductByCategory($id)
    {
        $sql = parent::$connection->prepare('SELECT count(products.id) as total_product_of_category FROM products INNER JOIN products_categories ON products.id = products_categories.product_id WHERE category_id=?');
        $sql->bind_param('i', $id);
        return parent::select($sql)[0]['total_product_of_category'];
    }

    public function getProductsSortUpFollowPrice($page, $perpage)
    {
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare('SELECT * FROM products ORDER BY product_price ASC LIMIT ?, ?;');
        $sql->bind_param('ii', $start, $perpage);
        return parent::select($sql);
    }

    public function getProductsSortDownFollowPrice($page, $perpage)
    {
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare('SELECT * FROM products ORDER BY product_price DESC LIMIT ?, ?;');
        $sql->bind_param('ii', $start, $perpage);
        return parent::select($sql);
    }

    public function getProductsSortUpFollowStar($page, $perpage)
    {
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare('SELECT * FROM products ORDER BY product_star ASC LIMIT ?, ?;');
        $sql->bind_param('ii', $start, $perpage);
        return parent::select($sql);
    }

    public function getProductsSortDownFollowStar($page, $perpage)
    {
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare('SELECT * FROM products ORDER BY product_star DESC LIMIT ?, ?;');
        $sql->bind_param('ii', $start, $perpage);
        return parent::select($sql);
    }

    public function getProductsFindSortUpFollowPrice($page, $perpage, $nameFind)
    {
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare('SELECT * FROM products WHERE product_name LIKE ? ORDER BY product_price ASC LIMIT ?, ?;');
        $nameFind = "%{$nameFind}%";
        $sql->bind_param('sii', $nameFind, $start, $perpage);
        return parent::select($sql);
    }

    public function getProductsFindSortDownFollowPrice($page, $perpage, $nameFind)
    {
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare('SELECT * FROM products WHERE product_name LIKE ? ORDER BY product_price DESC LIMIT ?, ?;');
        $nameFind = "%{$nameFind}%";
        $sql->bind_param('sii', $nameFind, $start, $perpage);
        return parent::select($sql);
    }

    public function getProductsFindSortUpFollowStar($page, $perpage, $nameFind)
    {
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare('SELECT * FROM products WHERE product_name LIKE ? ORDER BY product_star ASC LIMIT ?, ?;');
        $nameFind = "%{$nameFind}%";
        $sql->bind_param('sii', $nameFind, $start, $perpage);
        return parent::select($sql);
    }

    public function getProductsFindSortDownFollowStar($page, $perpage, $nameFind)
    {
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare('SELECT * FROM products WHERE product_name LIKE ? ORDER BY product_star DESC LIMIT ?, ?;');
        $nameFind = "%{$nameFind}%";
        $sql->bind_param('sii', $nameFind, $start, $perpage);
        return parent::select($sql);
    }

    public function getProductsCategorySortUpFollowPrice($id, $page, $perpage)
    {
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare('SELECT * FROM products INNER JOIN products_categories ON products.id = products_categories.product_id WHERE category_id=? ORDER BY products.product_price ASC LIMIT ?, ?;');
        $sql->bind_param('iii', $id, $start, $perpage);
        return parent::select($sql);
    }

    public function getProductsCategorySortDownFollowPrice($id, $page, $perpage)
    {
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare('SELECT * FROM products INNER JOIN products_categories ON products.id = products_categories.product_id WHERE category_id=? ORDER BY products.product_price DESC LIMIT ?, ?;');
        $sql->bind_param('iii', $id, $start, $perpage);
        return parent::select($sql);
    }

    public function getProductsCategorySortUpFollowStar($id, $page, $perpage)
    {
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare('SELECT * FROM products INNER JOIN products_categories ON products.id = products_categories.product_id WHERE category_id=? ORDER BY products.product_star ASC LIMIT ?, ?;');
        $sql->bind_param('iii', $id, $start, $perpage);
        return parent::select($sql);
    }

    public function getProductsCategorySortDownFollowStar($id, $page, $perpage)
    {
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare('SELECT * FROM products INNER JOIN products_categories ON products.id = products_categories.product_id WHERE category_id=? ORDER BY products.product_star DESC LIMIT ?, ?;');
        $sql->bind_param('iii', $id, $start, $perpage);
        return parent::select($sql);
    }

    public function viewProduct($id)
    {
        $sql = parent::$connection->prepare('UPDATE products SET `product_view` = `product_view` + 1 WHERE `id` = ?');
        $sql->bind_param('i', $id);
        return $sql->execute();
    }

    public function likeProductUser($productId, $username)
    {
        $sql = parent::$connection->prepare('INSERT INTO `user_product_like`(`product_id`, `username`) VALUES (?, ?)');
        $sql->bind_param('is', $productId, $username);
        return $sql->execute();
    }
}
