<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use MoveElevator\RequirementsChecker\RequirementsCheckerApplication;

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Requirement Checker</title>
    <style>
        .failure {
            background-color: crimson;
            color: #fff;
        }

        .success {
            background-color: darkgreen;
            color: #fff;
        }
    </style>
</head>
<body>
<?php

$givenFile = basename($_GET['config-file'] ?? '');
if (empty($givenFile)) {
    throw new RuntimeException('no config file given as GET-parameter like "?config-file=example-config.yaml"');
}
$requirementsChecker = new RequirementsCheckerApplication(sprintf('./%s', $givenFile));

$output = '<h1>Check requirements</h1>';
$output .= '<table>';

foreach ($requirementsChecker->check() as $result) {
    $output .= '<tr>';

    $cssClass = 'failure';
    if ($result->isSuccess()) {
        $cssClass = 'success';
    }

    $output .= sprintf('<td class="%s">%s</td>', $cssClass, $result->getName());
    $output .= sprintf('<td>%s</td>', $result->getMessage());
    $output .= '</tr>';
}

$output .= '</table>';

echo $output;
?>
</body>
</html>
