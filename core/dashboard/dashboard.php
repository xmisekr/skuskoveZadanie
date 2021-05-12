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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <title>Dashboard</title>
    </head>

    <body>
      
        <input type="hidden" name="student_name" id="student_name" value="Samuel">
        <input type="hidden" name="student_surname" id="student_surname" value="Hudak">
        <input type="hidden" name="teacher_id" id="teacher_id" value="1">

        <section class="dashboard">
        
            <div class="container">
                <div class="dropdown">
                    <a class="dropdown-toggle float-right mb-4" id="dropdown" type="button" data-toggle="dropdown">
                        <i class="fa fa-envelope"></i> <span class="badge badge-danger" id="notification-counter">0/span>
                    </a>

                    <ul class="dropdown-menu" id="dropdown-menu">
                    </ul>
                </div>

                <table class="table-tests table" cellspacing="0">
                    <thead class="tests-header ">
                        <tr class="row2 header">
                            <th class="test-name cell">Test name</th>
                            <th class="test-key cell">Shared key</th>
                            <th class="test-active cell">Active</th>
                            <th class="test-edit cell">Edit points</th>
                            <th class="test-watch cell">Watch test</th>
                        </tr>
                        
                    </thead>

                    <tbody class="tests-body">
                        <?php foreach($tests as $test): ?>
                            <tr class="tests-row row2">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>	
        <script src="../notification/notification.js"></script>
        <script src="dashboard.js"></script>
    </body>

</html>