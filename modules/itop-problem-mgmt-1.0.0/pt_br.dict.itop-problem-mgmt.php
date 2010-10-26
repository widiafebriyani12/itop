<?php
// Copyright (C) 2010 Combodo SARL
//
//   This program is free software; you can redistribute it and/or modify
//   it under the terms of the GNU General Public License as published by
//   the Free Software Foundation; version 3 of the License.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of the GNU General Public License
//   along with this program; if not, write to the Free Software
//   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

/**
 * Localized data
 *
 * @author      Erwan Taloc <erwan.taloc@combodo.com>
 * @author      Romain Quetiez <romain.quetiez@combodo.com>
 * @author      Denis Flaven <denis.flaven@combodo.com>
 * @license     http://www.opensource.org/licenses/gpl-3.0.html LGPL
 */

Dict::Add('PT BR', 'Brazilian', 'Brazilian', array(
        'Menu:ProblemManagement' => 'Gerenciamento Problemas',
        'Menu:ProblemManagement+' => 'Gerenciamento Problemas',
    	'Menu:Problem:Overview' => 'Visão geral',
    	'Menu:Problem:Overview+' => 'Visão geral',
    	'Menu:NewProblem' => 'Novo Problema',
    	'Menu:NewProblem+' => 'Novo Problema',
    	'Menu:SearchProblems' => 'Pesquisa para Problemas',
    	'Menu:SearchProblems+' => 'Pesquisa para Problemas',
    	'Menu:Problem:Shortcuts' => 'Atalhos',
        'Menu:Problem:MyProblems' => 'My Problems',
        'Menu:Problem:MyProblems+' => 'My Problems',
        'Menu:Problem:OpenProblems' => 'Todos Problemas abertos',
        'Menu:Problem:OpenProblems+' => 'Todos Problemas abertos',
	'UI-ProblemManagementOverview-ProblemByService' => 'Problems by Service',
	'UI-ProblemManagementOverview-ProblemByService+' => 'Problems by Service',
	'UI-ProblemManagementOverview-ProblemByPriority' => 'Problems by Priority',
	'UI-ProblemManagementOverview-ProblemByPriority+' => 'Problems by Priority',
	'UI-ProblemManagementOverview-ProblemUnassigned' => 'Unassigned Problems',
	'UI-ProblemManagementOverview-ProblemUnassigned+' => 'Unassigned Problems',
	'UI:ProblemMgmtMenuOverview:Title' => 'Dashboard for Problem Management',
	'UI:ProblemMgmtMenuOverview:Title+' => 'Dashboard for Problem Management',

));
//
// Class: Problem
//

Dict::Add('PT BR', 'Brazilian', 'Brazilian', array(
	'Class:Problem' => 'Problema',
	'Class:Problem+' => '',
	'Class:Problem/Attribute:status' => 'Status',
	'Class:Problem/Attribute:status+' => '',
	'Class:Problem/Attribute:status/Value:new' => 'New',
	'Class:Problem/Attribute:status/Value:new+' => '',
	'Class:Problem/Attribute:status/Value:assigned' => 'Assigned',
	'Class:Problem/Attribute:status/Value:assigned+' => '',
	'Class:Problem/Attribute:status/Value:resolved' => 'Resolved',
	'Class:Problem/Attribute:status/Value:resolved+' => '',
	'Class:Problem/Attribute:status/Value:closed' => 'Closed',
	'Class:Problem/Attribute:status/Value:closed+' => '',
	'Class:Problem/Attribute:org_id' => 'Customer',
	'Class:Problem/Attribute:org_id+' => '',
	'Class:Problem/Attribute:org_name' => 'Name',
	'Class:Problem/Attribute:org_name+' => 'Common name',
	'Class:Problem/Attribute:service_id' => 'Service',
	'Class:Problem/Attribute:service_id+' => '',
	'Class:Problem/Attribute:service_name' => 'Name',
	'Class:Problem/Attribute:service_name+' => '',
	'Class:Problem/Attribute:servicesubcategory_id' => 'Service Category',
	'Class:Problem/Attribute:servicesubcategory_id+' => '',
	'Class:Problem/Attribute:servicesubcategory_name' => 'Name',
	'Class:Problem/Attribute:servicesubcategory_name+' => '',
	'Class:Problem/Attribute:product' => 'Product',
	'Class:Problem/Attribute:product+' => '',
	'Class:Problem/Attribute:impact' => 'Impact',
	'Class:Problem/Attribute:impact+' => '',
	'Class:Problem/Attribute:impact/Value:1' => 'A Person',
	'Class:Problem/Attribute:impact/Value:1+' => '',
	'Class:Problem/Attribute:impact/Value:2' => 'A Service',
	'Class:Problem/Attribute:impact/Value:2+' => '',
	'Class:Problem/Attribute:impact/Value:3' => 'A Department',
	'Class:Problem/Attribute:impact/Value:3+' => '',
	'Class:Problem/Attribute:urgency' => 'Urgency',
	'Class:Problem/Attribute:urgency+' => '',
	'Class:Problem/Attribute:urgency/Value:1' => 'Low',
	'Class:Problem/Attribute:urgency/Value:1+' => 'Low',
	'Class:Problem/Attribute:urgency/Value:2' => 'Medium',
	'Class:Problem/Attribute:urgency/Value:2+' => 'Medium',
	'Class:Problem/Attribute:urgency/Value:3' => 'High',
	'Class:Problem/Attribute:urgency/Value:3+' => 'High',
	'Class:Problem/Attribute:priority' => 'Priority',
	'Class:Problem/Attribute:priority+' => '',
	'Class:Problem/Attribute:priority/Value:1' => 'Low',
	'Class:Problem/Attribute:priority/Value:1+' => '',
	'Class:Problem/Attribute:priority/Value:2' => 'Medium',
	'Class:Problem/Attribute:priority/Value:2+' => '',
	'Class:Problem/Attribute:priority/Value:3' => 'High',
	'Class:Problem/Attribute:priority/Value:3+' => '',
	'Class:Problem/Attribute:workgroup_id' => 'WorkGroup',
	'Class:Problem/Attribute:workgroup_id+' => '',
	'Class:Problem/Attribute:workgroup_name' => 'Name',
	'Class:Problem/Attribute:workgroup_name+' => '',
	'Class:Problem/Attribute:agent_id' => 'Agent',
	'Class:Problem/Attribute:agent_id+' => '',
	'Class:Problem/Attribute:agent_name' => 'Agent Name',
	'Class:Problem/Attribute:agent_name+' => '',
	'Class:Problem/Attribute:agent_email' => 'Agent Email',
	'Class:Problem/Attribute:agent_email+' => '',
	'Class:Problem/Attribute:related_change_id' => 'Related Change',
	'Class:Problem/Attribute:related_change_id+' => '',
	'Class:Problem/Attribute:related_change_ref' => 'Ref',
	'Class:Problem/Attribute:related_change_ref+' => '',
	'Class:Problem/Attribute:close_date' => 'Close Date',
	'Class:Problem/Attribute:close_date+' => '',
	'Class:Problem/Attribute:last_update' => 'Last Update',
	'Class:Problem/Attribute:last_update+' => '',
	'Class:Problem/Attribute:assignment_date' => 'Assignment Date',
	'Class:Problem/Attribute:assignment_date+' => '',
	'Class:Problem/Attribute:resolution_date' => 'Resolution Date',
	'Class:Problem/Attribute:resolution_date+' => '',
	'Class:Problem/Attribute:knownerrors_list' => 'Known Errors',
	'Class:Problem/Attribute:knownerrors_list+' => '',
	'Class:Problem/Stimulus:ev_assign' => 'Assign',
	'Class:Problem/Stimulus:ev_assign+' => '',
	'Class:Problem/Stimulus:ev_reassign' => 'Reaassign',
	'Class:Problem/Stimulus:ev_reassign+' => '',
	'Class:Problem/Stimulus:ev_resolve' => 'Resolve',
	'Class:Problem/Stimulus:ev_resolve+' => '',
	'Class:Problem/Stimulus:ev_close' => 'Close',
	'Class:Problem/Stimulus:ev_close+' => '',
));
?>