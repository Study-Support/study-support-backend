<?php

namespace App\Services\Login;

interface LoginServiceInterface
{
  /**
   * Form action login
   *
   * @param $data
   * @return \Illuminate\Http\Response
   */
  public function actionLogin($data);

  /**
	 * Form action logout
	 *
	 * @return \Illuminate\Http\Response
	 */
  public function actionLogout();
}
