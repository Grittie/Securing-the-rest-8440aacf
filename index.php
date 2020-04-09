<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> Netland CP</title>
</head>

<body>
    <?php
    function select($query)
    {
        $host = 'localhost';
        $db   = 'netland';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $formatResult = array();

        $rawResult = $pdo->query($query);
        while ($row = $rawResult->fetch()) {
            $rowResult = array();

            foreach ($row as $column => $value) {
                $rowResult[$column] = $value;
            }

            $formatResult[] = $rowResult;
        }

        return $formatResult;
    }
    ?>

    <h1> Welcome to the Netland control panel </h1>
    <h3> Series <a href="create.php?type=series"> add</a> </h3>

    <?php
    if (isset($_GET['seriesOrder'])) {
        $order = $_GET['seriesOrder'];

        if ($order == 'title') {
            $seriesData = 'SELECT * FROM media WHERE serie = true ORDER BY title';
        } else {
            $seriesData = 'SELECT * FROM media WHERE serie = true ORDER BY rating';
        }
    } else {
        $seriesData = 'SELECT * FROM media WHERE serie = true';
    }
    ?>
    <table>
        <thead>
            <td style="font-weight:bold"><a href=index.php?seriesOrder=title> Title </a></td>
            <td style="font-weight:bold"><a href=index.php?seriesOrder=rating> Rating </a></td>
            <th></th>
        </thead>
        <tbody>
            <?php
            $rows = select('SELECT * FROM media WHERE serie = true');
            foreach ($rows as $row) {
                echo <<<EOT
                        <tr>
                            <td>${row['title']}</td>
                            <td>${row['rating']}</td>
                            <td><a href="info.php?id=${row['id']}">More info</a></td>
                        </tr>
                    EOT;
            }
            ?>
        </tbody>
    </table>


    <h3>Films <a href="create.php?type=movies"> add</a></h3>

    <table>
        <thead>
            <th>Titel</th>
            <th>Beoordeling</th>
            <th></th>
        </thead>
        <tbody>
            <?php
            $rows = select('SELECT * FROM media WHERE serie = false');
            foreach ($rows as $row) {
                echo <<<EOT
                            <tr>
                                <td>${row['title']}</td>
                                <td>${row['rating']}</td>
                                <td><a href="info.php?id=${row['id']}">More info</a></td>
                            </tr>
                        EOT;
            }
            ?>
        </tbody>
    </table>
</body>

</html>