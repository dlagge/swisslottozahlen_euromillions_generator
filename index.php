<!DOCTYPE html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Swisslottozahlen Generator</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="random_generator.js"></script>
    <script type="text/javascript" src="d3.min.js"></script>
</head>
<body>
<h1>Swisslottozahlen Generator</h1>
<button id="mi_sa_button" onclick="mi_sa_button();">Mittwoch und Samstag ausgewählt</button>
<div class="plate" id="plate0">
    <button id="the_big_button" onclick="create_lottonumbers()">Lottozahlen generieren</button>
    <input type="radio" name="numsel" id="all_sel" onchange="select_all_buttons();"><label>Alle Zahlen
        selektieren</label><br>
    <input type="radio" name="numsel" id="random_sel" onchange="deselect_all_buttons();" checked><label>Alle Zahlen
        deselektieren</label>
    <div id="random_buttons">
        <script>create_buttons();</script>
    </div>
    <div id="wrapper1">
        <div class="zahl" id="zahl1"><p class="box" id="box1">-</p></div>
        <div class="zahl" id="zahl2"><p class="box" id="box2">-</p></div>
        <div class="zahl" id="zahl3"><p class="box" id="box3">-</p></div>
        <div class="zahl" id="zahl4"><p class="box" id="box4">-</p></div>
        <div class="zahl" id="zahl5"><p class="box" id="box5">-</p></div>
        <div class="zahl" id="zahl6"><p class="box" id="box6">-</p></div>
        <div class="zahl" id="zahl7"><p class="box" id="box7">-</p></div>
    </div>
    <div id="autoscroll">
        <table id="tab"></table>
    </div>
</div>

<div id="wrapper2">
    <div class="plate" id="plate1">
        <div class="ziehungen" id="ziehung_mittwoch">Ziehung Mittwoch</div>
        <div id="db_mi">
            <form action="" method="post">
                <div id="wrap1">
                    <div id="lotto_numbers_mi">
                        <input type="number" class="Lottozahl" name="Lottozahl1_mi" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl2_mi" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl3_mi" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl4_mi" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl5_mi" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl6_mi" min="1" max="42">
                        <input type="number" class="Lottozahl" id="Glueckszahl" name="Glueckszahl_mi" min="1" max="6">
                        <input type="date" id="datepicker" name="Datum_mi" step=7 min=2010-01-06>
                        <input name="submit_mi" id="eintragen_mi" type="submit" value="eintragen">
                    </div>
                    <div id="tab_plate1">
                        <script>create_detailed_table("tab_plate1", "mi");</script>
                    </div>
                </div>
            </form>
            <div id="autoscroll">
				<?php require_once("db_lotto_mi.php") ?>
            </div>
        </div>
    </div>

    <div class="plate" id="plate2">
        <div class="ziehungen" id="ziehung_mittwoch_h">Ziehungshäufigkeit Mittwoch</div>
        <div id="zi_mi">
            <div id="autoscroll">
                <div id="mi_datab"></div>
            </div>
            <div id="autoscroll">
                <div id="mi_datab_g"></div>
            </div>
			<?php require_once("ziehungsstatistik_mi.php"); ?>
        </div>
    </div>


    <div class="plate" id="plate3">
        <div class="ziehungen" id="ziehung_samstag">Ziehung Samstag</div>
        <div id="db_sa">
            <form action="" method="post">
                <div id="wrap3">
                    <div id="lotto_numbers_sa">
                        <input type="number" class="Lottozahl" name="Lottozahl1_sa" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl2_sa" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl3_sa" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl4_sa" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl5_sa" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl6_sa" min="1" max="42">
                        <input type="number" class="Lottozahl" id="Glueckszahl" name="Glueckszahl_sa" min="1" max="6">
                        <input type="date" id="datepicker" name="Datum_sa" step=7 min=2010-01-02>
                        <input name="submit_sa" id="eintragen_sa" type="submit" value="eintragen">
                    </div>
                    <div id="tab_plate3">
                        <script>create_detailed_table("tab_plate3", "sa");</script>
                    </div>
                </div>

            </form>

            <div id="autoscroll">
				<?php require_once("db_lotto_sa.php") ?>
            </div>
        </div>
    </div>

    <div class="plate" id="plate4">
        <div class="ziehungen" id="ziehung_samstag_h">Ziehungshäufigkeit Samstag</div>
        <div id="zi_sa">
            <div id="autoscroll">
                <div id="sa_datab"></div>
            </div>
            <div id="autoscroll">
                <div id="sa_datab_g"></div>
            </div>
			<?php require_once("ziehungsstatistik_sa.php"); ?>
        </div>
    </div>
</div>

<div class="footer">
    <p>Made with love<br>
        <a href="mailto:dominique.lagger@gmail.com">dominique.lagger@gmail.com</a></p>
</div>
</body>
</html>
