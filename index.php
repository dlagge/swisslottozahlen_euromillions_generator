<!DOCTYPE html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Lottozahlengenerator</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="random_generator.js"></script>
    <script type="text/javascript" src="d3.min.js"></script>
</head>
<body>
<h1>Lottozahlengenerator</h1>
<div id="swiss_euro_settings">
    <div id="swiss_euro_buttons">
        <input type="image" class="swiss_euro" id="swiss" src="swisslotto_button.png" onclick="show_swisslotto();" />
        <input type="image" class="swiss_euro" id="euromill" src="euromillions_button.png" onclick="show_euromillions();"/>
    </div>
    <form>
    <div id="swiss_settings">
            <h2>Swisslotto</h2>
             <fieldset>
                <input value="mi_sa_swiss" name="swiss_euro_radio" onclick="display();" type="radio"><label>Mittwoch und Samstag anzeigen</label><br>
                <input value="mi_swiss" name="swiss_euro_radio" onclick="display();" type="radio"><label>Mittwoch anzeigen</label><br>
                <input value="sa_swiss" name="swiss_euro_radio" onclick="display();" type="radio"><label>Samstag anzeigen</label>
             </fieldset>
    </div>
    <div id="euro_settings">
            <h2>Euromillions</h2>
            <fieldset>
                <input name="swiss_euro_radio" onclick="display();" type="radio"><label>Dienstag und Freitag anzeigen</label><br>
                <input name="swiss_euro_radio" onclick="display();" type="radio"><label>Dienstag anzeigen</label><br>
                <input name="swiss_euro_radio" onclick="display();" type="radio"><label>Freitag anzeigen</label>
            </fieldset>
    </div>
    </form>
</div>
<div class="plate" id="plate0">
    <button class="the_big_button" id="the_big_button_swiss" onclick="create_lottonumbers(6, 42, 6);">Lottozahlen generieren</button>
    <button class="the_big_button" id="the_big_button_euro" onclick="create_lottonumbers(12, 50, 5);">Lottozahlen generieren</button>
    <div id="swiss_selector">
        <input type="radio" name="numsel_swiss" onclick="select_all_buttons(42);"><label>Alle Zahlen selektieren</label><br>
        <input type="radio" name="numsel_swiss" onclick="deselect_all_buttons(42);"><label>Alle Zahlen deselektieren</label>
    </div>
    <div id="euro_selector">
        <input type="radio" name="numsel_euro" onclick="select_all_buttons(50);"><label>Alle Zahlen selektieren</label><br>
        <input type="radio" name="numsel_euro" onclick="deselect_all_buttons(50);"><label>Alle Zahlen deselektieren</label>
    </div>
    <div id="random_buttons"></div>
    <div id="wrapper1">
        <div class="zahl" id="zahl1"><p class="box" id="box1">-</p></div>
        <div class="zahl" id="zahl2"><p class="box" id="box2">-</p></div>
        <div class="zahl" id="zahl3"><p class="box" id="box3">-</p></div>
        <div class="zahl" id="zahl4"><p class="box" id="box4">-</p></div>
        <div class="zahl" id="zahl5"><p class="box" id="box5">-</p></div>
        <div class="zahl" id="zahl6"><p class="box" id="box6">-</p></div>
        <div class="zahl" id="zahl7"><p class="box" id="box7">-</p></div>
        <div class="zahl" id="zahl8"><p class="box" id="box8">-</p></div>
    </div>
    <div id="autoscroll">
        <table id="tab"></table>
    </div>
</div>

<div id="wrapper2">
    <div class="plate" id="plate1">
        <div class="ziehungen" id="ziehung_mittwoch">Ziehung Mittwoch
            <img src="swisslotto_button.png" class="pic">
        </div>
        <div id="db_mi">
            <form action="" method="post">
                <div id="wrap">
                    <div id="lotto_numbers_mi">
                        <input type="number" class="Lottozahl" name="Lottozahl1_mi" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl2_mi" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl3_mi" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl4_mi" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl5_mi" min="1" max="42">
                        <input type="number" class="Lottozahl" id="Lottozahl6_mi" name="Lottozahl6_mi" min="1" max="42">
                        <input type="number" class="Lottozahl Glueckszahl" name="Glueckszahl_mi" min="1" max="6">
                        <input type="date" id="datepicker" name="Datum_mi" step=7 min=2010-01-06>
                        <input name="submit_mi" class="eintragen" type="submit" value="eintragen">
                    </div>
                    <div id="tab_plate1">
                        <script>create_detailed_table("tab_plate1", "mi", 6, 7);</script>
                    </div>
                </div>
            </form>
            <div id="autoscroll">
				<?php require_once("db_lotto_mi.php") ?>
            </div>
        </div>
    </div>

    <div class="plate" id="plate2">
        <div class="ziehungen" id="ziehung_mittwoch_h">Ziehungshäufigkeit Mittwoch
        <img src="swisslotto_button.png" class="pic">
        </div>
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
        <div class="ziehungen" id="ziehung_samstag">Ziehung Samstag
        <img src="swisslotto_button.png" class="pic">
        </div>
        <div id="db_sa">
            <form action="" method="post">
                <div id="wrap">
                    <div id="lotto_numbers_sa">
                        <input type="number" class="Lottozahl" name="Lottozahl1_sa" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl2_sa" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl3_sa" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl4_sa" min="1" max="42">
                        <input type="number" class="Lottozahl" name="Lottozahl5_sa" min="1" max="42">
                        <input type="number" class="Lottozahl" id="Lottozahl6_sa" name="Lottozahl6_sa" min="1" max="42">
                        <input type="number" class="Lottozahl Glueckszahl" name="Glueckszahl_sa" min="1" max="6">
                        <input type="date" id="datepicker" name="Datum_sa" step=7 min=2010-01-02>
                        <input name="submit_sa" class="eintragen" type="submit" value="eintragen">
                    </div>
                    <div id="tab_plate3">
                        <script>create_detailed_table("tab_plate3", "sa", 6, 7);</script>
                    </div>
                </div>

            </form>

            <div id="autoscroll">
				<?php require_once("db_lotto_sa.php") ?>
            </div>
        </div>
    </div>

    <div class="plate" id="plate4">
        <div class="ziehungen" id="ziehung_samstag_h">Ziehungshäufigkeit Samstag
        <img src="swisslotto_button.png" class="pic">
        </div>
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

    <div class="plate" id="plate5">
            <div class="ziehungen" id="ziehung_dienstag">Ziehung Dienstag
            <img src="euromillions_button.png" class="pic">
            </div>
            <div id="db_di">
                <form action="" method="post">
                    <div id="wrap">
                        <div id="lotto_numbers_di">
                            <input type="number" class="Lottozahl" name="Lottozahl1_di" min="1" max="50">
                            <input type="number" class="Lottozahl" name="Lottozahl2_di" min="1" max="50">
                            <input type="number" class="Lottozahl" name="Lottozahl3_di" min="1" max="50">
                            <input type="number" class="Lottozahl" name="Lottozahl4_di" min="1" max="50">
                            <input type="number" class="Lottozahl" name="Lottozahl5_di" min="1" max="50">
                            <input type="number" class="Lottozahl Glueckszahl" id="glueck1" name="Glueckszahl1_di" min="1" max="12">
                            <input type="number" class="Lottozahl Glueckszahl" name="Glueckszahl2_di" min="1" max="12">
                            <input type="date" id="datepicker" name="Datum_di" step=7 min=2010-01-05>
                            <input name="submit_di" class="eintragen" type="submit" value="eintragen">
                        </div>
                        <div id="tab_plate5">
                            <script>create_detailed_table("tab_plate5", "di", 5, 10);</script>
                        </div>
                    </div>

                </form>

                <div id="autoscroll">
    				<?php require_once("db_lotto_di.php") ?>
                </div>
            </div>
    </div>

    <div class="plate" id="plate6">
            <div class="ziehungen" id="ziehung_dienstag_h">Ziehungshäufigkeit Dienstag
            <img src="euromillions_button.png" class="pic">
            </div>
            <div id="zi_di">
                <div id="autoscroll">
                    <div id="di_datab"></div>
                </div>
                <div id="autoscroll">
                    <div id="di_datab_g"></div>
                </div>
    			<?php require_once("ziehungsstatistik_di.php"); ?>
            </div>
    </div>

    <div class="plate" id="plate7">
                <div class="ziehungen" id="ziehung_freitag">Ziehung Freitag
                <img src="euromillions_button.png" class="pic">
                </div>
                <div id="db_fr">
                    <form action="" method="post">
                        <div id="wrap">
                            <div id="lotto_numbers_fr">
                                <input type="number" class="Lottozahl" name="Lottozahl1_fr" min="1" max="50">
                                <input type="number" class="Lottozahl" name="Lottozahl2_fr" min="1" max="50">
                                <input type="number" class="Lottozahl" name="Lottozahl3_fr" min="1" max="50">
                                <input type="number" class="Lottozahl" name="Lottozahl4_fr" min="1" max="50">
                                <input type="number" class="Lottozahl" name="Lottozahl5_fr" min="1" max="50">
                                <input type="number" class="Lottozahl Glueckszahl" id="glueck1" name="Glueckszahl1_fr" min="1" max="12">
                                <input type="number" class="Lottozahl Glueckszahl" name="Glueckszahl2_fr" min="1" max="12">
                                <input type="date" id="datepicker" name="Datum_fr" step=7 min=2010-01-01>
                                <input name="submit_fr" class="eintragen" type="submit" value="eintragen">
                            </div>
                            <div id="tab_plate7">
                                <script>create_detailed_table("tab_plate7", "fr", 5, 10);</script>
                            </div>
                        </div>

                    </form>

                    <div id="autoscroll">
        				<?php require_once("db_lotto_fr.php") ?>
                    </div>
                </div>
        </div>

        <div class="plate" id="plate8">
                <div class="ziehungen" id="ziehung_freitag_h">Ziehungshäufigkeit Freitag
                <img src="euromillions_button.png" class="pic">
                </div>
                <div id="zi_fr">
                    <div id="autoscroll">
                        <div id="fr_datab"></div>
                    </div>
                    <div id="autoscroll">
                        <div id="fr_datab_g"></div>
                    </div>
        			<?php require_once("ziehungsstatistik_fr.php"); ?>
                </div>
        </div>


        <div class="plate" id="plate9">
            <div class="ziehungen" id="ziehung_mittwoch_samstag">Ziehung Mittwoch und Samstag
                <img src="swisslotto_button.png" class="pic">
            </div>
            <div id="db_mi_sa">
                <div id="autoscroll">
        		    <?php require_once("db_lotto_mi_sa.php") ?>
                </div>
            </div>
        </div>

        <div class="plate" id="plate10">
            <div class="ziehungen" id="ziehung_mittwoch_samstag_h">Ziehungshäufigkeit Mittwoch und Samstag
                <img src="swisslotto_button.png" class="pic">
            </div>
            <div id="zi_mi_sa">
                <div id="autoscroll">
                    <div id="mi_sa_datab"></div>
                </div>
                <div id="autoscroll">
                    <div id="mi_sa_datab_g"></div>
                </div>
        		<?php require_once("ziehungsstatistik_mi_sa.php"); ?>
            </div>
        </div>

        <div class="plate" id="plate11">
            <div class="ziehungen" id="ziehung_dienstag_freitag">Ziehung Dienstag und Freitag
                <img src="euromillions_button.png" class="pic">
            </div>
            <div id="db_di_fr">
                <div id="autoscroll">
        		    <?php require_once("db_lotto_di_fr.php") ?>
                </div>
            </div>
        </div>

        <div class="plate" id="plate12">
            <div class="ziehungen" id="ziehung_dienstag_freitag_h">Ziehungshäufigkeit Dienstag und Freitag
                <img src="euromillions_button.png" class="pic">
            </div>
            <div id="zi_di_fr">
                <div id="autoscroll">
                    <div id="di_fr_datab"></div>
                </div>
                <div id="autoscroll">
                    <div id="di_fr_datab_g"></div>
                </div>
        		<?php require_once("ziehungsstatistik_di_fr.php"); ?>
            </div>
        </div>


</div>

<div class="footer">
    <p>Made with love<br>
        <a href="mailto:dominique.lagger@gmail.com">dominique.lagger@gmail.com</a></p>
</div>
</body>
</html>
