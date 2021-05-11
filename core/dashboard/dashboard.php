<?php
include_once '../../path.php';
include_once ROOT_PATH . '/repository/SharedRepository.php';

$repository = new SharedRepository();
$tests = $repository->selectAll('test', ['teacher_id' => $_GET['teacher_id']]);


if (isset($_POST['test_id'], $_POST['active'])){
    $id = intval($_POST['test_id']);
    $active = intval($_POST['active']);
    $data['active'] = $active;

    $repository->update('test', $id, $data);
}
?>

<!DOCTYPE html>
<html lang="sk">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles.css" type="text/css"/>

        <title>Dashboard</title>
    </head>

    <body>

        <section class="dashboard">
            <table class="table-tests">
                <thead class="tests-header">
                    <th class="test-name">Test name</th>
                    <th class="test-key">Shared key</th>
                    <th class="test-active">Active</th>
                    <th class="test-edit">Edit points</th>
                    <th class="test-watch">Watch test</th>
                </thead>

                <tbody class="tests-body">
                    <?php foreach($tests as $test): ?>
                        <tr class="tests-row">
                            <td><?php echo $test['name']?></td>
                            <td><?php echo $test['shared_key']?></td>

                            <td>
                                <?php if($test['active'] == true): ?>
                                    <input type="checkbox" class="test-active" name="test-active" id="test-active" checked>

                                <?php else: ?>
                                    <input type="checkbox" class="test-active" name="test-active" id="test-active">
                                    
                                <?php endif; ?>
                                
                                <input type="hidden" name='test_id' value="<?php echo $test['id']?>">
                            </td>

                            <td><a href="">Go</a></td>
                            <td><a href="<?php echo '../watchTest/watchTest.php?test_id=' . $test['id'] ?>">Go</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="new-test">
                <a href="" class="create-test">New test</a>
            </div>
        </section>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>	
        <script src="dashboard.js"></script>
    </body>

</html>