
<html lang="en" class="no-js" style="min-height: 100%; height: 100%;">

<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>temp</title>

    <meta name="description" content="description"/>
    <meta name="keywords" content=""/>
    <meta name="author" content=""/>
    <style>
        *,
        *:after,
        *:before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            font-family: 'Futura Light';
        }

        @font-face {
            font-family: 'Futura Extended';
            src: url('fonts/Futura Extended.eot');
            src: local('☺'), url('fonts/Futura Extended.woff') format('woff'), url('fonts/Futura Extended.ttf') format('truetype'), url('fonts/Futura Extended.svg') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Futura Koyu';
            src: url('fonts/Futura Koyu.eot');
            src: local('☺'), url('fonts/Futura Koyu.woff') format('woff'), url('fonts/Futura Koyu.ttf') format('truetype'), url('fonts/Futura Koyu.svg') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Futura Light';
            src: url('fonts/Futura Light.eot');
            src: local('☺'), url('fonts/Futura Light.woff') format('woff'), url('fonts/Futura Light.ttf') format('truetype'), url('fonts/Futura Light.svg') format('svg');
            font-weight: normal;
            font-style: normal;
        }

    </style>
</head>


<?php
    $path = 'images/';
?>

<body style="min-height: 100%; height: 100%;">

<div class="container" style="padding: 30px;">

    <div class="header-section">
        <p>Dear manager,</p>

        <p>In the week <?=$stats['global_stats']['start_date']?> - <?=$stats['global_stats']['end_date']?> we have the following figures available for you:</p>
        <ul class="main-stats" style="list-style: none;">
            <li>
                <span class="stat-name"   style="display: inline-block; min-width: 250px;">- Total logins:</span>
                <span class="first-stat"  style="display: inline-block; font-family: 'Futura Extended';"><?php echo $stats['global_stats']['total_logins']; ?></span>
                <span class="separator"   style="display: inline-block; width: 1px; margin: 0 5px; position: relative; top: 2px; height: 15px; background-color: #000;"></span>
                <?php $loc = $diff['global_stats']['total_logins'];
                    if ($loc > 0) {
                        $color = 'green';
                    } elseif ($loc < 0) {
                        $color = 'red';
                    }
                ?>
                <span class="second-stat" style="color: <?=$color?>; display: inline-block; font-family: 'Futura Extended';"><?php echo ($loc > 0)?"+$loc":$loc ?>%</span>
            </li>
            <li>
                <span class="stat-name"  style="display: inline-block; min-width: 250px;">- Total answered questions:</span>
                <span class="first-stat" style="display: inline-block; font-family: 'Futura Extended';"><?php echo $stats['global_stats']['total_answered_questions']; ?></span>
                <span class="separator"  style="display: inline-block; width: 1px; margin: 0 5px; position: relative; top: 2px; height: 15px; background-color: #000;"></span>
                <?php $loc = $diff['global_stats']['total_answered_questions'];
                    if ($loc > 0) {
                        $color = 'green';
                    } elseif ($loc < 0) {
                        $color = 'red';
                    }
                ?>
                <span class="second-stat" style="color: <?=$color?>; display: inline-block; font-family: 'Futura Extended';"><?php echo ($loc > 0)?"+$loc":$loc ?>%</span>
            </li>
            <li>
                <span class="stat-name"  style="display: inline-block; min-width: 250px;">- Total MB's transferred</span>
                <span class="first-stat" style="display: inline-block; font-family: 'Futura Extended';"><?php echo $stats['global_stats']['total_mb_transfered'] ?></span>
                <span class="separator"  style="display: inline-block; width: 1px; margin: 0 5px; position: relative; top: 2px; height: 15px; background-color: #000;"></span>
                <?php $loc = $diff['global_stats']['total_mb_transfered'];
                    if ($loc > 0) {
                        $color = 'green';
                    } elseif ($loc < 0) {
                        $color = 'red';
                    }
                ?>
                <span class="second-stat" style="color: <?=$color?>; display: inline-block; font-family: 'Futura Extended';"><?php echo ($loc > 0)?"+$loc":$loc ?>%</span>
            </li>
            <li>
                <span class="stat-name"  style="display: inline-block; min-width: 250px;">- Total users:</span>
                <span class="first-stat" style="display: inline-block; font-family: 'Futura Extended';"><?php echo $stats['global_stats']['total_users'] ?></span>
                <span class="separator"  style="display: inline-block; width: 1px; margin: 0 5px; position: relative; top: 2px; height: 15px; background-color: #000;"></span>
                <?php $loc = $diff['global_stats']['total_users'];
                    if ($loc > 0) {
                        $color = 'green';
                    } elseif ($loc < 0) {
                        $color = 'red';
                    }
                ?>
                <span class="second-stat" style="color: <?=$color?>; display: inline-block; font-family: 'Futura Extended';"><?php echo ($loc > 0)?"+$loc":$loc ?>%</span>
            </li>
            <li>
                <span class="stat-name"  style="display: inline-block; min-width: 250px;">- Total unique users</span>
                <span class="first-stat" style="display: inline-block; font-family: 'Futura Extended';"><?php echo $stats['global_stats']['total_unique_users'] ?></span>
                <span class="separator"  style="display: inline-block; width: 1px; margin: 0 5px; position: relative; top: 2px; height: 15px; background-color: #000;"></span>
                <?php $loc = $diff['global_stats']['total_unique_users'];
                    if ($loc > 0) {
                        $color = 'green';
                    } elseif ($loc < 0) {
                        $color = 'red';
                    }
                ?>
                <span class="second-stat" style="color: <?=$color?>; display: inline-block; font-family: 'Futura Extended';"><?php echo ($loc > 0)?"+$loc":$loc ?>%</span>
            </li>
        </ul>
    </div>

    <div class="questions">
        <?php
        $counter = 1;
        foreach ($stats['questions_stats'] as $question_id => $question) {
            $question_diff = $diff['questions_stats'][$question_id];
            ?>
            <div class="one-question" style="font-family: 'Futura Extended'; font-size: 25px;">
                <div class="question-header">
                    <div class="question">
                        <span>Question <?php echo $counter; ?>:</span>
                        <span class="question-self"><?php echo $question['question_text']; ?></span>
                    </div>

                    <div class="question-stats">
                        <span class="stat-name"  style="display: inline-block; vertical-align: middle;">Total answers:</span>
                        <span class="first-stat" style="display: inline-block; vertical-align: middle;"><?php echo $question['total_answers']; ?></span>
                        <?php $loc = $question_diff['total_answers'];
                            if ($loc > 0) {
                                $color = 'green';
                            } elseif ($loc < 0) {
                                $color = 'red';
                            }
                        ?>
                        <span class="second-stat" style="color: <?=$color?>; display: inline-block; vertical-align: middle;"><?php echo ($loc > 0)?"+$loc":$loc; ?>%</span>
                        <span class="separator"   style="display: inline-block; vertical-align: middle; width: 2px; margin: 0 5px; position: relative; top: 0px; height: 25px; background-color: #000;"></span>

                        <span class="stat-icon"   style="display: inline-block; vertical-align: middle; width: 40px; height: 40px;">
                            <img src="<?php echo base_url("assets/variables/" . $question['icons']['icon_1']); ?>" style="width: 100%; height: 100%;" alt="">
                        </span>
                        <span class="first-stat"  style="display: inline-block; vertical-align: middle;"><?php echo $question['likes']; ?></span>
                            <?php $loc = $question_diff['likes'];
                                if ($loc > 0) {
                                    $color = 'green';
                                } elseif ($loc < 0) {
                                    $color = 'red';
                                }
                            ?>
                        <span class="second-stat" style="color: <?=$color?>; display: inline-block; vertical-align: middle;"><?php echo ($loc > 0)?"+$loc":$loc; ?>%</span>
                        <span class="separator"   style="display: inline-block; vertical-align: middle; width: 2px; margin: 0 5px; position: relative; top: 0px; height: 25px; background-color: #000;"></span>

                        <span class="stat-icon"   style="display: inline-block; vertical-align: middle; width: 40px; height: 40px;">
                            <img src="<?php echo base_url("assets/variables/" . $question['icons']['icon_2']) ?>" style="width: 100%; height: 100%;" alt="">
                        </span>
                        <span class="first-stat"  style="display: inline-block; vertical-align: middle;"><?php echo $question['neutral']; ?></span>
                            <?php $loc = $question_diff['neutral'];
                                if ($loc > 0) {
                                    $color = 'green';
                                } elseif ($loc < 0) {
                                    $color = 'red';
                                }
                            ?>
                        <span class="second-stat" style="color: <?=$color?>; display: inline-block; vertical-align: middle;"><?php echo ($loc > 0)?"+$loc":$loc; ?>%</span>
                        <span class="separator"   style="display: inline-block; vertical-align: middle; width: 2px; margin: 0 5px; position: relative; top: 0px; height: 25px; background-color: #000;"></span>

                        <span class="stat-icon"   style="display: inline-block; vertical-align: middle; width: 40px; height: 40px;">
                            <img src="<?php echo base_url("assets/variables/" . $question['icons']['icon_3']) ?>" style="width: 100%; height: 100%;" alt="">
                        </span>
                        <span class="first-stat"  style="display: inline-block; vertical-align: middle;"><?php echo $question['dislike']; ?></span>
                            <?php $loc = $question_diff['dislike'];
                                if ($loc > 0) {
                                    $color = 'green';
                                } elseif ($loc < 0) {
                                    $color = 'red';
                                }
                            ?>
                        <span class="second-stat" style="color: <?=$color?>; display: inline-block; vertical-align: middle;"><?php echo ($loc > 0)?"+$loc":$loc; ?>%</span>
                    </div>

                </div>
                <div class="question-graphic"></div>
            </div>
        <?php } ?>
    </div>

</div>

</body>

</html>
