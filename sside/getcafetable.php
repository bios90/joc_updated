<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
require_once('../vendor/autoload.php');
require_once('db.php');
require_once('helpers/global_helper.php');
require_once('helpers/db_helper.php');
require_once('models/Model_Cafe.php');


$sort = null;

if(postHaveValue('sort'))
{
    $sort = getPostValue('sort');
}

$cafes = getAllCafes($sort);


ob_start();
?>

<?php foreach ($cafes as $cafe): ?>
    <tr class="cafe_row" data-cafe-id="<?= $cafe->id ?>">
        <td class="text-center p-0">
            <div class="p-2 text-center column-logo">
                <img class="table_logo" src="/images/cafelogos/<?= $cafe->logo_name ?>" alt="">
            </div>
        </td>
        <td class="column-name text-center">
            <p class="p-2" data-toggle="tooltip" data-placement="top" title="<?= $cafe->name ?>"><?= $cafe->name ?></p>
        </td>
        <td class="column-adress text-center">
            <p class="p-2" data-toggle="tooltip" data-placement="top" title="<?= $cafe->adress_fact ?>"><?= $cafe->adress_fact ?></p>
        </td>
        <td class="column-dir text-center">
            <p class="p-2" data-toggle="tooltip" data-placement="top" title="<?= $cafe->dirfio ?>"><?= $cafe->dirfio ?></p>
        </td>
        <td class="column-phone text-center">
            <p class="p-2"><a href="tel:+7(999)7773333"><?= $cafe->phone ?></a></p>
        </td>
        <td class="column-email text-center">
            <p class="p-2"><a href="mailto:+7(999)7773333"><?= $cafe->email ?></a></p>
        </td>
        <td class="column-status text-center">
            <?php

            if ($cafe->status == 1)
            {
                echo "<button href='' class='btn-status status-green mx-auto' data-cafe-id='$cafe->id' data-toggle='tooltip' data-placement='top' title='Отозвать одобрение'>Одобрен</button>";
            } else
            {
                echo "<button href='' class='btn-status status-yellow mx-auto' data-cafe-id='$cafe->id' data-toggle='tooltip' data-placement='top' title='Одобрить'>Ожидание</button>";

            }

            ?>

        </td>
    </tr>
<?php endforeach; ?>

<?php

$content = ob_get_clean();
echo $content;
?>
