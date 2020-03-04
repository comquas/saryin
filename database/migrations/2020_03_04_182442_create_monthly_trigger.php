<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        create trigger report_monthlies_trigger AFTER insert on transactions FOR EACH ROW
BEGIN
	DECLARE rowCount INT;
 
	SET rowCount = (SELECT count(*) FROM report_monthlies WHERE `month` = MONTH(NEW.date) AND `year` = YEAR(NEW.date) and type = new.type);
	IF rowCount = 0 THEN
		Insert into report_monthlies(`month`,`year`,`amount`,`type`) values (MONTH(NEW.date),YEAR(NEW.date),new.amount,new.type);
	ELSE
		Update report_monthlies SET `amount` = `amount` + new.amount WHERE `month` = MONTH(NEW.date) AND `year` =YEAR(NEW.date) and type = new.type;
	END IF;
END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("drop trigger report_monthlies_trigger");
    }
}
