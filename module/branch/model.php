<?php
/**
 * The model file of branch module of ZenTaoCMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     branch
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class branchModel extends model
{
    public function getById($branchID)
    {
        if(empty($branchID)) return $this->lang->branch->all;
        return $this->dao->select('*')->from(TABLE_BRANCH)->where('id')->eq($branchID)->fetch('name');
    }

    public function getPairs($productID, $params = '')
    {
        $branches = $this->dao->select('*')->from(TABLE_BRANCH)->where('product')->eq($productID)->andWhere('deleted')->eq(0)->orderBy('id_asc')->fetchPairs('id', 'name');
        if(strpos($params, 'noempty') === false) $branches = array('0' => $this->lang->branch->all) + $branches;
        return $branches;
    }

    public function manage($productID)
    {
        $oldBranches = $this->getPairs($productID, 'noempty');
        $data = fixer::input('post')->get();
        if(isset($data->branch))
        {
            foreach($data->branch as $branchID => $branch)
            {
                if($oldBranches[$branchID] != $branch) $this->dao->update(TABLE_BRANCH)->set('name')->eq($branch)->where('id')->eq($branchID)->exec();
            }
        }
        foreach($data->newbranch as $branch)
        {
            if(empty($branch)) continue;
            $this->dao->insert(TABLE_BRANCH)->set('name')->eq($branch)->set('product')->eq($productID)->exec();
        }

        return dao::isError();
    }

    public function getByProducts($products, $params = '')
    {
        $branches = $this->dao->select('*')->from(TABLE_BRANCH)->where('product')->in($products)->andWhere('deleted')->eq(0)->fetchAll();

        $branchGroups = array();
        foreach($branches as $branch)
        {
            if(!isset($branchGroups[$branch->product]) and strpos($params, 'noempty') === false) $branchGroups[$branch->product][0] = $this->lang->branch->all;
            $branchGroups[$branch->product][$branch->id] = $branch->name;
        }

        return $branchGroups;
    }
}
