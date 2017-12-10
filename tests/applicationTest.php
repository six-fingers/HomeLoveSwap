<?php

use PHPUnit\Framework\TestCase;


final class ApplicationTest extends TestCase
{

  public function testFileGenerator() {
    $year = date('Y');
    $fileName = 'example.csv';
    $response = fileGenerator($fileName, $year);

    $this->assertFileExists($fileName);
    $this->assertInternalType('string', $response);
    $this->assertEquals('string', $response);
  }

  public function testIsWeekendDay() {

    $this->assertInternalType('boolean', isWeekendDay(date('Y-m-d')) );

    if(date('D') === 'Sat' || date('D') === 'Sun') {
      $this->assertTrue( isWeekendDay(date('Y-m-d')) );
    } else {
      $this->assertFalse( isWeekendDay(date('Y-m-d')) );
    }
  }

  public function testArrayGenerator() {

    $year = date('Y');
    $fileContent = arrayGenerator(date('Y'));
    $this->assertInternalType( 'array', $fileContent );
    $this->assertCount( 13, $fileContent );

    foreach ($fileContent as $rowKey => $row) {

      $this->assertInternalType( 'string', $row );

      $columns = explode(',', $row);
      $this->assertInternalType( 'array', $columns );
      $this->assertCount( 4, $columns );

      if ($rowKey == 0) {
        $this->assertEquals( $columns[0], "\"Month Name\"" );
        $this->assertEquals( $columns[1], " \"1st expenses day\"" );
        $this->assertEquals( $columns[2], " \"2nd expenses day\"" );
        $this->assertEquals( $columns[3], " \"Salary day\"\n" );
      } else {
        var_dump($columns);
        $monthName = date("F", strtotime("$year-$rowKey-01"));
        $this->assertContains( "\"$monthName\"", $columns);
      }
    }

  }

}
