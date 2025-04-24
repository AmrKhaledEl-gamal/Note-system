<?php
require_once 'assets/php/admin-header.php';
require_once 'assets/php/admin-db.php';
$count = new Admin();
?>


    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap gap-3 mt-3 text-center justify-content-center">
                
                <div class="card bg-primary flex-fill">
                    <div class="card-header text-light fw-bold">Total Users</div>
                    <div class="card-body">
                        <h1 class="display-4 fw-bold text-light">
                            <?=$count->totalCount('users');?>
                        </h1>
                    </div>
                </div>
                <div class="card bg-warning flex-fill">
                    <div class="card-header text-light fw-bold">Verified Users</div>
                    <div class="card-body">
                        <h1 class="display-4 fw-bold text-light">
                            <?=$count->verified_users(1);?>
                        </h1>
                    </div>
                </div>
                <div class="card bg-success flex-fill">
                    <div class="card-header text-light fw-bold">unverified Users</div>
                    <div class="card-body">
                        <h1 class="display-4 fw-bold text-light">
                        <?=$count->verified_users(0);?>
                        </h1>
                    </div>
                </div>
                <div class="card bg-danger flex-fill">
                    <div class="card-header text-light fw-bold">Website Hit</div>
                    <div class="card-body">
                        <h1 class="display-4 fw-bold text-light">
                            <?php $data = $count->site_hits(); echo $data['hits'];?>
                        </h1>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap gap-3 mt-3 text-center justify-content-center">
                <div class="card bg-danger flex-fill">
                    <div class="card-header">Total Notes</div>
                    <div class="card-body">
                        <h1 class="display-4 fw-bold">
                            <?=$count->totalCount('notes');?>
                        </h1>
                </div>
            </div>
                <div class="card bg-success flex-fill">
                    <div class="card-header">Total Feedback</div>
                    <div class="card-body">
                        <h1 class="display-4 fw-bold">
                        <?=$count->totalCount('feedback');?>
                        </h1>
                    </div>
                </div>
                <div class="card bg-info flex-fill">
                    <div class="card-header">Total Notification</div>
                    <div class="card-body">
                        <h1 class="display-4 fw-bold">
                            <?=$count->totalCount('notification');?>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-lg-12">
        <div class="d-flex flex-wrap gap-3 mt-3 justify-content-center">
            <div class="card border-success flex-fill" style="min-width: 300px; max-width: 600px;">
                <div class="card-header bg-success text-center text-white lead">
                    Male/Female User's Percentage
                </div>
                <div id="chatOne" style="height: 400px;"></div>
            </div>
            <div class="card border-info flex-fill" style="min-width: 300px; max-width: 600px;">
                <div class="card-header bg-info text-center text-white lead">
                    Verified/Unverified User's Percentage
                </div>
                <div id="chatTwo" style="height: 400px;"></div>
            </div>
        </div>
    </div>
</div>


<!-- footer Area -->
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
                    checkNotification();

function checkNotification(){
    $.ajax({
        url:'assets/php/admin-action.php',
        method: 'post',
        data:{action: 'checkNotification'},
        success:function(response){
            console.log(response)
            $("#checkNotification").html(response)
        }
    }
    )
}
        google.charts.load('current', {packages:['corechart']});
        google.charts.setOnLoadCallback(pieChart);

        function pieChart() {
            var data = google.visualization.arrayToDataTable([
                ['Gender', 'Number'],
                <?php
                $gender = $count->genderper();
                foreach ($gender as $row) {
                    echo "['".$row['gender']."',".$row['number']."],";
                }
                ?>
            ]);

            var options = {
                is3D: false,
            };

            var chart = new google.visualization.PieChart(document.getElementById('chatOne'));
            chart.draw(data, options);
        }
        // Verified/Unverified User's Percentage
        google.charts.load('current', {packages:['corechart']});
        google.charts.setOnLoadCallback(colchart);

        function colchart() {
            var data = google.visualization.arrayToDataTable([
                ['Verified', 'Number'],
                <?php
                $verified = $count->verifiedper();
                foreach ($verified as $row) {
                    if($row['verified'] == 0){
                        $row['verified'] = 'Unverified';
                }else{
                        $row['verified'] = 'verified';
                    }
                    echo "['".$row['verified']."',".$row['number']."],";
                }
                ?>
            ]);
            var options = {
                pieHole: 0.4,
            };
            var chart = new google.visualization.PieChart(document.getElementById('chatTwo'));
            chart.draw(data, options);
        }
    </script>
    </body>
</html>