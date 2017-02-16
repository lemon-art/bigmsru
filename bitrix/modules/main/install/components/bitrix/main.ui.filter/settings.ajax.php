<?

define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);

use Bitrix\Main\UI\Filter\Actions;
use Bitrix\Main\Web;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$response = new \Bitrix\Main\HttpResponse(\Bitrix\Main\Application::getInstance()->getContext());
$response->addHeader("Content-Type", "application/json");

if (!$USER->IsAuthorized())
{
	$response->flush(Web\Json::encode(array(
		"error" => "Not authorized"
	)));

	die();
}

$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$request->addFilter(new Web\PostDecodeFilter);

if (!$request->isAjaxRequest())
{
	$response->flush(Web\Json::encode(array(
		"error" => "Request is not XHR"
	)));

	die();
}

if (!$request->isPost())
{
	$response->flush(Web\Json::encode(array(
		"error" => "Request is not POST"
	)));

	die();
}


$options = new \Bitrix\Main\UI\Filter\Options($request->get("FILTER_ID"));
$gridOptions = new \Bitrix\Main\Grid\Options($request->get("GRID_ID"));
$error = false;

switch ($request->get("action"))
{
	case Actions::SET_FILTER : {
		$options->setFilters(array($request->getPostList()->toArray()));

		$rows = $request->getPost("filter_rows");
		$filterId = $request->getPost("filter_id");
		$filterName = $request->getPost("name");
		$filterFields = $request->getPost("fields");

		$gridOptions->SetFilterRows($rows, $filterId);
		$gridOptions->SetFilterSettings($filterId, array(
			"name" => $filterName,
			"fields" => $filterFields
		));
		break;
	}

	default : {
		$error = true;
		break;
	}
}

if (!$error)
{
	$options->save();
	$gridOptions->Save();

	$response->flush(Web\Json::encode($options->getOptions()));
}
else
{
	$response->flush(Web\Json::encode(array(
		"error" => "Unknown action",
		"action" => $request->get("action")
	)));
}