
<!DOCTYPE html>
<html lang="sk">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles.css" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Watch test</title>
    </head>
        
    <body>
        <input type="hidden" name="student_name" id="student_name" value="Samuel">
        <input type="hidden" name="student_surname" id="student_surname" value="Hudak">
        <input type="hidden" name="teacher_id" id="teacher_id" value="1">

        <section class="watch-test">
            <input id="test_id" type="hidden" value="<?php echo $_GET['test_id'] ?>">
            <div class="container">
                <div class="dropdown">
                    <a class="dropdown-toggle float-right mb-4" id="dropdown" type="button" data-toggle="dropdown">
                        <i class="fa fa-envelope"></i> <span class="badge badge-danger" id="notification-counter">0/span>
                    </a>

                    <ul class="dropdown-menu" id="dropdown-menu">
                    </ul>
                </div>

                <table class="users table" cellspacing="0">
                    <thead class="users-header">
                        <tr class="row2 header">
                            <th class="users-name cell">Name</th>
                            <th class="users-surname cell">Surname</th>
                            <th class="users-in-test cell">In test</th>
                            <th class="users-completed cell">Completed</th>
                        </tr>
                    </thead>

                    <tbody id="table-body" class="users-body"></tbody>
                </table>
            </div>
            
        </section>
        

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>	
        <script src="../notification/notification.js"></script>	
        <script src="handleAttendance.js"></script>  
          
    </body>


</html>