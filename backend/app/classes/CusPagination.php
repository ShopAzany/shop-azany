<?php
class CusPagination
{
	public static function pagination_links($limit, $count, $page, $link_limit)
	{
		$total_link = ceil($count / $limit);
		$links_per_page = $link_limit;
		$pageLinks = [];
		$start = 1;
		if ($page >= 4) {
			$start = ($page - 4) + 2;
			if (($start + ($links_per_page - 1)) > $total_link) {
				$start = ($total_link + 1) - $links_per_page;
			}
		}
		$linkCount = 0;
		for ($i = $start; $i < ($total_link + 1); $i++) {
			$linkCount++;
			array_push($pageLinks, $i);
			if ($linkCount == $links_per_page) {
				break;
			}
		}
		return array("links"=>$pageLinks, "totalLink"=>$total_link);
	}
}
