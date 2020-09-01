<?php
class SiteSystemParameters 
{

	public static function getParmValue($paramkey)
	{
		try 
		{
			$model = SystemParameter::model()->findByAttributes(array("parm_key"=>$paramkey));
			return trim($model->parm_value);
		}
		catch (Exception $ex)
		{
			return null;
		}
	}
	public static function getAllParms()
	{
		try 
		{
			$all = SystemParameter::model()->findAll();
			$parms = array();
			foreach ($all as $model)
			{
				$parms[$model->parm_key] = trim($model->parm_value);
			}
			return $parms;
		}
		catch (Exception $ex)
		{
			return null;
		}
	}
}
