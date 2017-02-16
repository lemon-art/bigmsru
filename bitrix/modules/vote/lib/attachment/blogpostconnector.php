<?
namespace Bitrix\Vote\Attachment;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

final class BlogPostConnector extends Connector
{
	private $canRead = null;
	private $canEdit = null;
	private static $permissions = array();

	private function getPermission($userId)
	{
		if (!Loader::includeModule('socialnetwork'))
			return false;
		else if (!array_key_exists($this->entityId, self::$permissions))
		{
			$cacheTtl = 2592000;
			$cacheId = 'blog_post_socnet_general_' . $this->entityId . '_' . LANGUAGE_ID;
			$timezoneOffset = \CTimeZone::getOffset();
			if($timezoneOffset != 0)
			{
				$cacheId .= "_" . $timezoneOffset;
			}
			$cacheDir = '/blog/socnet_post/gen/' . intval($this->entityId / 100) . '/' . $this->entityId;

			$cache = new \CPHPCache;
			if($cache->initCache($cacheTtl, $cacheId, $cacheDir))
			{
				$post = $cache->getVars();
			}
			else
			{
				$cache->startDataCache();
				$post = \CBlogPost::getList(array(), array("ID" => $this->entityId), false, false, array(
					"ID",
					"BLOG_ID",
					"PUBLISH_STATUS",
					"TITLE",
					"AUTHOR_ID",
					"ENABLE_COMMENTS",
					"NUM_COMMENTS",
					"VIEWS",
					"CODE",
					"MICRO",
					"DETAIL_TEXT",
					"DATE_PUBLISH",
					"CATEGORY_ID",
					"HAS_SOCNET_ALL",
					"HAS_TAGS",
					"HAS_IMAGES",
					"HAS_PROPS",
					"HAS_COMMENT_IMAGES"
				))->fetch();
				$cache->endDataCache($post);
			}
			self::$permissions[$this->entityId] = BLOG_PERMS_DENY;
			if ($post && $post["ID"] > 0)
			{
				$p = \CBlogPost::getSocNetPostPerms($this->entityId, true, $userId, $post["AUTHOR_ID"]);
				if ($p > BLOG_PERMS_MODERATE || ($p >= BLOG_PERMS_WRITE && $post["AUTHOR_ID"] == $userId))
					$p = BLOG_PERMS_FULL;
				self::$permissions[$this->entityId] = $p;
			}

		}
		return self::$permissions[$this->entityId];
	}
	/**
	 * @param integer $userId User ID.
	 * @return bool
	 */
	public function canRead($userId)
	{
		if(is_null($this->canRead))
			$this->canRead = $this->getPermission($userId) >= BLOG_PERMS_READ;

		return $this->canRead;
	}

	/**
	 * @param integer $userId User ID.
	 * @return bool
	 */
	public function canEdit($userId)
	{
		if(is_null($this->canEdit))
			$this->canEdit = $this->getPermission($userId) > BLOG_PERMS_MODERATE;

		return $this->canEdit;
	}
}
