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
        <link rel="stylesheet" href="styles.css?version=51" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <title>Dashboard</title>
    </head>

    <body>

        <section class="dashboard">
            <div class="container">
                <table class="table-tests table" cellspacing="0">
                    <thead class="tests-header ">
                        <tr class="row header">
                            <th class="test-name cell">Test name</th>
                            <th class="test-key cell">Shared key</th>
                            <th class="test-active cell">Active</th>
                            <th class="test-edit cell">Edit points</th>
                            <th class="test-watch cell">Watch test</th>
                        </tr>
                        
                    </thead>

                    <tbody class="tests-body">
                        <?php foreach($tests as $test): ?>
                            <tr class="tests-row row">
                                <td class="cell"><?php echo $test['name']?></td>
                                <td class="cell"><?php echo $test['shared_key']?></td>

                                <td class="cell">
                                    <?php if($test['active'] == true): ?>
                                        <input type="checkbox" class="test-active toggle" name="test-active" id="test-active" checked>

                                    <?php else: ?>
                                        <input type="checkbox" class="test-active toggle" name="test-active" id="test-active">
                                        
                                    <?php endif; ?>
                                    
                                    <input type="hidden" name='test_id' value="<?php echo $test['id']?>">
                                </td>

                                <td class="cell"><a href=""><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
                                <td class="cell"><a href="<?php echo '../watchTest/watchTest.php?test_id=' . $test['id'] ?>"><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="new-test">
                    <a href="" class="create-test">New test</a>
                </div>
            </div>
            
        </section>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>	
        <script src="dashboard.js"></script>
    </body>

</html>