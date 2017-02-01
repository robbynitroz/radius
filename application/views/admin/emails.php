<html lang="en">
<head>
    <meta charset="utf-8"/>

    <link type="text/css" rel="stylesheet" href='/assets/css/bootstrap.min.css'/>
</head>

<body>

    <div class="container">
        <h2 style="text-align: center">
            Users Emails
        </h2>

        <form action="/index.php/admin/main/emails" method="post">
            <input type="hidden" name="read_and_send" value="1">
            <button class="btn btn-success col-md-12" style="margin: 15px 0;">
                Refresh
            </button>
        </form>

        <table class="table">
            <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th>Alias:</th>
                <th>Customer email:</th>
                <th>First name:</th>
                <th>Last name:</th>
                <th>Checked in date:</th>
                <th>Checked out date:</th>
                <th>Email status:</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach($emails as $key => $array) {
                    foreach($array as $key2 => $value) {
                        echo '<tr>';
                        echo '<th scope="row">' . $i++ . '</th>';
                        echo '<th>'.  $value['alias'] .'</th>';
                        echo '<td>' . $value['email'] . '</td>';
                        echo '<td>' . $value['firstname'] . '</td>';
                        echo '<td>' . $value['lastname'] . '</td>';
                        echo '<td>' . $value['attribute_1'] . '</td>';
                        echo '<td>' . $value['attribute_2'] . '</td>';
                        echo '<td>' . $value['status'] . '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>

    </div>
</body>
</html>