<?php
error_reporting(-1);
ini_set('display_errors', 'On');
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/helpers/global_helper.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/helpers/db_helper.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/models/Model_Cafe.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/models/Model_Product.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/models/Model_Add.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/models/Model_Weight.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/models/Model_Milk.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/models/Model_News.php');


function getCafeFromRow($row)
{
    $cafe = new Model_Cafe();
    $cafe->setData($row);

    return $cafe;
}

function getCafeById($id, $conn)
{
    $sql = "SELECT * FROM `cafe` WHERE `id`=$id";
    $result = mysqli_query($conn, $sql);
    if (!$result)
    {
        return null;
    }

    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $cafe = new Model_Cafe();
    $cafe->setData($row);
//    $cafe->setId($row['id']);
//    $cafe->setEmail($row['email']);
//    $cafe->setName($row['name']);
//    $cafe->setOoo($row['ooo']);
//    $cafe->setOkpo($row['okpo']);
//    $cafe->setAdressUr($row['adress_ur']);
//    $cafe->setAdressFact($row['adress_fact']);
//    $cafe->setDirfio($row['dirfio']);
//    $cafe->setPhone($row['phone']);
//    $cafe->setInn($row['inn']);
//    $cafe->setHourOt($row['hour_ot']);
//    $cafe->setHourDo($row['hour_do']);
//    $cafe->setMinuteOt($row['minute_ot']);
//    $cafe->setMinuteDo($row['minute_do']);
//    $cafe->setLogoName($row['logo_name']);
//    $cafe->setStatus($row['status']);

    return $cafe;
}

function getProductById($id)
{
    global $conn;
    $sql = "SELECT * FROM `products` WHERE `id`=$id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (!$result)
    {
        return null;
    }

    if (mysqli_num_rows($result) == 0)
    {
        return null;
    }


    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $product = new Model_Product();
    $product->setData($row);

    if ($product->categ == 0 || $product->categ == 1)
    {
        if ($weights = getProductWeights($product))
        {
            $product->listOfWeights = $weights;
        }

        if ($adds = getProductAdds($product))
        {
            $product->listOfAdds = $adds;
        }

        if ($milks = getProductMilks($product))
        {
            $product->listOfMilks = $milks;
        }
    }

    return $product;
}

function getProductWeights($product)
{
    global $conn;

    $item_id = $product->id;
    $weights = array();
    $sql = "SELECT * FROM `weights` WHERE `item_id`=$item_id";
    $result = mysqli_query($conn, $sql);
    if (!$result)
    {
        echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
        return false;
    }

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $model_weight = new Model_Weight();
        $model_weight->setData($row);
        $weights[] = $model_weight;
    }

    return $weights;
}

function getProductAdds($product)
{
    global $conn;

    $item_id = $product->id;
    $adds = array();

    $sql = "SELECT * FROM `adds` WHERE `item_id`=$item_id";
    $result = mysqli_query($conn, $sql);
    if (!$result)
    {
        echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
        return false;
    }


    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $model_add = new Model_Add();
        $model_add->setData($row);
        $adds[] = $model_add;
    }

    return $adds;
}

function getProductMilks($product)
{
    global $conn;

    $item_id = $product->id;
    $milks = array();

    $sql = "SELECT * FROM `milks` WHERE `item_id`=$item_id";
    $result = mysqli_query($conn, $sql);
    if (!$result)
    {
        echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
        return false;
    }

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $model_milk = new Model_Milk();
        $model_milk->setData($row);
        $milks[] = $model_milk;
    }

    return $milks;
}

function deleteWeights($product_id)
{
    global $conn;
    $sql = "DELETE FROM `weights` WHERE `item_id`=$product_id";
    $result = mysqli_query($conn, $sql);
    if (!$result)
    {
        echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
        return false;
    }

    return true;
}

function deleteAdds($product_id)
{
    global $conn;
    $sql = "DELETE FROM `adds` WHERE `item_id`=$product_id";
    $result = mysqli_query($conn, $sql);
    if (!$result)
    {
        echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
        return false;
    }

    return true;
}

function deleteMilks($product_id)
{
    global $conn;
    $sql = "DELETE FROM `milks` WHERE `item_id`=$product_id";
    $result = mysqli_query($conn, $sql);
    if (!$result)
    {
        echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
        return false;
    }

    return true;
}

function insertPostWeights($product_id)
{
    global $conn;
    $weights = array();

    for ($i = 0; $i <= 10; $i++)
    {
        if (isset($_POST["weight" . $i]))
        {
            $weight = getPostValue("weight" . $i);
            $price = getPostValue("weight_price" . $i);

            $model_weight = new Model_Weight();
            $model_weight->weight = $weight;
            $model_weight->price = $price;
            $model_weight->item_id = $product_id;

            $weights[] = $model_weight;
        }
    }

    foreach ($weights as $wei)
    {
        $sql = "INSERT INTO `weights`(`item_id`, `weight`, `price`) VALUES ({$wei->item_id},{$wei->weight},{$wei->price})";

        $result = mysqli_query($conn, $sql);
        if (!$result)
        {
            echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
            return false;
        }
    }

    return true;
}

function insertPostAdds($product_id)
{
    global $conn;
    $adds = array();

    for ($i = 0; $i <= 10; $i++)
    {
        if (isset($_POST["add" . $i]))
        {
            $text = getPostValue("add" . $i);
            $price = getPostValue("add_price" . $i);

            $model_add = new Model_Add();
            $model_add->text = $text;
            $model_add->price = $price;
            $model_add->item_id = $product_id;

            $adds[] = $model_add;
        }
    }


    foreach ($adds as $add)
    {
        $sql = "INSERT INTO `adds`(`item_id`, `text`, `price`) VALUES ({$add->item_id},'{$add->text}',$add->price)";

        $result = mysqli_query($conn, $sql);
        if (!$result)
        {
            echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
            return false;
        }
    }

    return true;
}

function insertPostMilks($product_id)
{
    global $conn;
    $milks = array();

    for ($i = 0; $i <= 10; $i++)
    {
        if (isset($_POST["milk" . $i]))
        {
            $text = getPostValue("milk" . $i);
            $price = getPostValue("milk_price" . $i);

            $model_milk = new Model_Milk();
            $model_milk->text = $text;
            $model_milk->price = $price;
            $model_milk->item_id = $product_id;

            $milks[] = $model_milk;
        }
    }

    foreach ($milks as $milk)
    {
        $sql = "INSERT INTO `milks`(`item_id`, `text`, `price`) VALUES ({$milk->item_id},'{$milk->text}',$milk->price)";

        $result = mysqli_query($conn, $sql);
        if (!$result)
        {
            echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
            return false;
        }
    }

    return true;
}

function deleteProduct($product_id)
{
    global $conn;

    $sql = "DELETE  FROM `products` WHERE `id`=$product_id";
    $result = mysqli_query($conn, $sql);
    if (!$result)
    {
        echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
        return false;
    }

    $sql = "DELETE FROM `milks` WHERE `item_id`=$product_id";
    $result = mysqli_query($conn, $sql);

    $sql = "DELETE FROM `weights` WHERE `item_id`=$product_id";
    $result = mysqli_query($conn, $sql);

    $sql = "DELETE FROM `adds` WHERE `item_id`=$product_id";
    $result = mysqli_query($conn, $sql);

    return true;

}

function getAllCafes($sort)
{
    global $conn;

    $sql = "SELECT * FROM `cafe`";

    if ($sort != null && columnExists($sort))
    {
        $sql .= " ORDER BY $sort";
    }


    $result = mysqli_query($conn, $sql);
    if (!$result)
    {
        return null;
    }

    $cafes = [];

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $cafe = new Model_Cafe();
        $cafe->setData($row);
        $cafes[] = $cafe;
    }

    return $cafes;
}

function getAllNews()
{
    global $conn;

    $sql = "SELECT * FROM `news` ORDER BY date DESC";


    $result = mysqli_query($conn, $sql);
    if (!$result)
    {
        return null;
    }

    $news = [];

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $newsone = new Model_News();
        $newsone->setData($row);
        $news[] = $newsone;
    }

    return $news;
}

function getNewsById($id)
{
    global $conn;

    $sql = "SELECT * FROM `news` WHERE id=$id LIMIT 1";


    $result = mysqli_query($conn, $sql);
    if (!$result)
    {
        return null;
    }


    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $news = new Model_News();
    $news->setData($row);

    return $news;
}

function columnExists($name)
{
    global $conn;

    $sql = "SHOW COLUMNS FROM `cafe` LIKE '$name'";
    $result = mysqli_query($conn, $sql);
    $exists = mysqli_num_rows($result) > 0 ? true : false;
    return $exists;
}


function changeStatus($id)
{
    global $conn;

    $sql = "UPDATE cafe SET status = IF(status=1, 0, 1) WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function insertNews($news)
{
    global $conn;

    $sql = "INSERT INTO `news`(`title`, `text` ";

    if ($news->image != null)
    {
        $sql .= ", `image` ";
    }
    $sql .= ") VALUES ('{$news->title}','{$news->text}'";
    if ($news->image != null)
    {
        $sql .= ", '{$news->image}' ";
    }
    $sql .= " )";


    $result = mysqli_query($conn, $sql);
    if (!$result)
    {
        return false;
    }

    return true;
}

function updateNews($news)
{
    global $conn;

    $sql = "UPDATE news SET `title` = '{$news->title}', `text` = '{$news->text}'";
    if($news->image != null)
    {
        $sql .= " , `image`='{$news->image}'";
    }

    $sql .=" WHERE `id`={$news->id}";


    $result = mysqli_query($conn, $sql);
    if (!$result)
    {
        return false;
    }

    return true;
}

function deleteNews($id)
{
    global $conn;

    $sql = "DELETE FROM `news` WHERE `id`=$id";
    $result = mysqli_query($conn, $sql);
    return true;
}


