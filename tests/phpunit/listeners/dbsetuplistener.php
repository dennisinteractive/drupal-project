<?php

class DbSetupListener implements PHPUnit_Framework_TestListener {

  public function addError(PHPUnit_Framework_Test $test, Exception $e, $time) {
    printf("Error while running test '%s'.\n", $test->getName());
  }

  public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time) {
    printf("Test '%s' failed.\n", $test->getName());
  }

  public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time) {
    printf("Test '%s' is incomplete.\n", $test->getName());
  }

  public function addRiskyTest(PHPUnit_Framework_Test $test, Exception $e, $time) {
    printf("Test '%s' is deemed risky.\n", $test->getName());
  }

  public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time) {
    printf("Test '%s' has been skipped.\n", $test->getName());
  }

  public function startTest(PHPUnit_Framework_Test $test) {

  }

  public function endTest(PHPUnit_Framework_Test $test, $time) {

  }

  public function startTestSuite(PHPUnit_Framework_TestSuite $suite) {
    $this->setupDatabase();
  }

  public function endTestSuite(PHPUnit_Framework_TestSuite $suite) {

  }

  protected function setupDatabase() {
    static $db_settings;

    if (!isset($db_settings)) {
      $settings_php = getcwd() . '/web/sites/default/settings.db.php';
      if (!file_exists($settings_php)) {
        printf("Cannot find '%s'. You can run drupal site:settings:db to generate it.\n", $settings_php);
        exit;
      }
      require_once($settings_php);

      $db_settings = reset($databases['default']);
      $db_conn = sprintf('%s://%s:%s@%s/%s',
        $db_settings['driver'],
        $db_settings['username'],
        $db_settings['password'],
        $db_settings['host'],
        $db_settings['database']
      );
      putenv("SIMPLETEST_DB=$db_conn");
    }
  }
}
