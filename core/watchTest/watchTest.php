
<!DOCTYPE html>
<html lang="sk">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles.css" type="text/css"/>

        <title>Watch test</title>
    </head>
        
    <body>
        <section class="watch-test">
            <input id="test_id" type="hidden" value="<?php echo $_GET['test_id'] ?>">
            <table class="users">
                <thead class="users-header">
                    <th class="users-name">Name</th>
                    <th class="users-surname">Surname</th>
                    <th class="users-in-test">In test</th>
                    <th class="users-completed">Completed</th>
                </thead>

                <tbody id="table-body" class="users-body"></tbody>
            </table>
        </section>
        

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>	
        <script src="handleAttendance.js"></script>  
          
    </body>


</html>