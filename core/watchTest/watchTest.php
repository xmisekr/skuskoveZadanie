
<!DOCTYPE html>
<html lang="sk">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles.css?version=51" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <title>Watch test</title>
    </head>
        
    <body>
        <section class="watch-test">
            <input id="test_id" type="hidden" value="<?php echo $_GET['test_id'] ?>">
            <div class="container">
                <table class="users table" cellspacing="0">
                    <thead class="users-header">
                        <tr class="row header">
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
        <script src="handleAttendance.js"></script>  
          
    </body>


</html>