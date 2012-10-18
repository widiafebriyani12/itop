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
 * @author	Erwan Taloc <erwan.taloc@combodo.com>
 * @author	Romain Quetiez <romain.quetiez@combodo.com>
 * @author	Denis Flaven <denis.flaven@combodo.com>
 * @author	Marco Tulio <mtulio@opensolucoes.com.br>

 * @licence	http://www.opensource.org/licenses/gpl-3.0.html LGPL
 */

Dict::Add('PT BR', 'Brazilian', 'Brazilian', array(
	'Class:lnkTicketToDoc' => 'Ticket/Documento',
	'Class:lnkTicketToDoc+' => '',
	'Class:lnkTicketToDoc/Attribute:ticket_id' => 'Ticket',
	'Class:lnkTicketToDoc/Attribute:ticket_id+' => '',
	'Class:lnkTicketToDoc/Attribute:document_id' => 'Documento',
	'Class:lnkTicketToDoc/Attribute:document_id+' => '',
	'Class:lnkTicketToContact' => 'Ticket/Contato',
	'Class:lnkTicketToContact+' => '',
	'Class:lnkTicketToContact/Attribute:ticket_id' => 'Ticket',
	'Class:lnkTicketToContact/Attribute:ticket_id+' => '',
	'Class:lnkTicketToContact/Attribute:contact_id' => 'Contato',
	'Class:lnkTicketToContact/Attribute:contact_id+' => '',
	'Class:lnkTicketToContact/Attribute:role' => 'Regra',
	'Class:lnkTicketToContact/Attribute:role+' => '',
	'Class:lnkTicketToCI' => 'Ticket/CI',
	'Class:lnkTicketToCI+' => '',
	'Class:lnkTicketToCI/Attribute:ticket_id' => 'Ticket',
	'Class:lnkTicketToCI/Attribute:ticket_id+' => '',
	'Class:lnkTicketToCI/Attribute:ci_id' => 'CI',
	'Class:lnkTicketToCI/Attribute:ci_id+' => '',
	'Class:lnkTicketToCI/Attribute:impact' => 'Impacto',
	'Class:lnkTicketToCI/Attribute:impact+' => '',
	'Class:Ticket' => 'Ticket',
	'Class:Ticket+' => '',
	'Class:Ticket/Attribute:ref' => 'Ref',
	'Class:Ticket/Attribute:ref+' => '',
	'Class:Ticket/Attribute:title' => 'Título',
	'Class:Ticket/Attribute:title+' => '',
	'Class:Ticket/Attribute:description' => 'Descrição',
	'Class:Ticket/Attribute:description+' => '',
	'Class:Ticket/Attribute:ticket_log' => 'Log',
	'Class:Ticket/Attribute:ticket_log+' => '',
	'Class:Ticket/Attribute:start_date' => 'Iniciado',
	'Class:Ticket/Attribute:start_date+' => '',
	'Class:Ticket/Attribute:document_list' => 'Documentos',
	'Class:Ticket/Attribute:document_list+' => 'Documentos relacionado ao ticket',
	'Class:Ticket/Attribute:ci_list' => 'CIs',
	'Class:Ticket/Attribute:ci_list+' => 'CIs preocupado com o incidente',
	'Class:Ticket/Attribute:contact_list' => 'Contatos',
	'Class:Ticket/Attribute:contact_list+' => 'Equipe(s) e pessoa(s) envolvidas',
	'Class:Ticket/Attribute:incident_list' => 'Incidentes relacionados',
	'Class:Ticket/Attribute:incident_list+' => '',
	'Class:Ticket/Attribute:finalclass' => 'Tipo',
	'Class:Ticket/Attribute:finalclass+' => '',
	'Ticket:baseinfo' => 'Informações gerais',
	'Ticket:date' => 'Datas',
	'Ticket:contact' => 'Contatos',
	'Ticket:moreinfo' => 'Mais informações',
	'Ticket:relation' => 'Relações',
	'Ticket:log' => 'Comunicações',
	'Class:lnkTicketToDoc/Attribute:ticket_ref' => 'Ticket #',
	'Class:lnkTicketToDoc/Attribute:ticket_ref+' => '',
	'Class:lnkTicketToDoc/Attribute:document_name' => 'Documento',
	'Class:lnkTicketToDoc/Attribute:document_name+' => '',
	'Class:lnkTicketToContact/Attribute:ticket_ref' => 'Ticket #',
	'Class:lnkTicketToContact/Attribute:ticket_ref+' => '',
	'Class:lnkTicketToContact/Attribute:contact_name' => 'Contato',
	'Class:lnkTicketToContact/Attribute:contact_name+' => '',
	'Class:lnkTicketToContact/Attribute:contact_email' => 'Email',
	'Class:lnkTicketToContact/Attribute:contact_email+' => '',
	'Class:lnkTicketToCI/Attribute:ticket_ref' => 'Ticket #',
	'Class:lnkTicketToCI/Attribute:ticket_ref+' => '',
	'Class:lnkTicketToCI/Attribute:ci_name' => 'CI',
	'Class:lnkTicketToCI/Attribute:ci_name+' => '',
	'Class:lnkTicketToCI/Attribute:ci_status' => 'CI status',
	'Class:lnkTicketToCI/Attribute:ci_status+' => '',
	'Class:ResponseTicket' => 'ResponseTicket',
	'Class:ResponseTicket+' => '',
	'Class:ResponseTicket/Attribute:status' => 'Status',
	'Class:ResponseTicket/Attribute:status+' => '',
	'Class:ResponseTicket/Attribute:status/Value:new' => 'Novo',
	'Class:ResponseTicket/Attribute:status/Value:new+' => 'novamente aberto',
	'Class:ResponseTicket/Attribute:status/Value:escalated_tto' => 'Escalada/TTO',
	'Class:ResponseTicket/Attribute:status/Value:escalated_tto+' => '',
	'Class:ResponseTicket/Attribute:status/Value:assigned' => 'Atribuádo',
	'Class:ResponseTicket/Attribute:status/Value:assigned+' => '',
	'Class:ResponseTicket/Attribute:status/Value:escalated_ttr' => 'Escalada/TTR',
	'Class:ResponseTicket/Attribute:status/Value:escalated_ttr+' => '',
	'Class:ResponseTicket/Attribute:status/Value:frozen' => 'Pendente',
	'Class:ResponseTicket/Attribute:status/Value:frozen+' => '',
	'Class:ResponseTicket/Attribute:status/Value:resolved' => 'Resolvido',
	'Class:ResponseTicket/Attribute:status/Value:resolved+' => '',
	'Class:ResponseTicket/Attribute:status/Value:closed' => 'Fechado',
	'Class:ResponseTicket/Attribute:status/Value:closed+' => '',
	'Class:ResponseTicket/Attribute:caller_id' => 'Solicitação',
	'Class:ResponseTicket/Attribute:caller_id+' => '',
	'Class:ResponseTicket/Attribute:caller_email' => 'Email',
	'Class:ResponseTicket/Attribute:caller_email+' => '',
	'Class:ResponseTicket/Attribute:org_id' => 'Cliente',
	'Class:ResponseTicket/Attribute:org_id+' => '',
	'Class:ResponseTicket/Attribute:org_name' => 'Cliente',
	'Class:ResponseTicket/Attribute:org_name+' => '',
	'Class:ResponseTicket/Attribute:service_id' => 'Serviço',
	'Class:ResponseTicket/Attribute:service_id+' => '',
	'Class:ResponseTicket/Attribute:service_name' => 'Nome',
	'Class:ResponseTicket/Attribute:service_name+' => '',
	'Class:ResponseTicket/Attribute:servicesubcategory_id' => 'Elemento Serviço',
	'Class:ResponseTicket/Attribute:servicesubcategory_id+' => '',
	'Class:ResponseTicket/Attribute:servicesubcategory_name' => 'Nome',
	'Class:ResponseTicket/Attribute:servicesubcategory_name+' => '',
	'Class:ResponseTicket/Attribute:product' => 'Produto',
	'Class:ResponseTicket/Attribute:product+' => '',
	'Class:ResponseTicket/Attribute:impact' => 'Impacto',
	'Class:ResponseTicket/Attribute:impact+' => '',
	'Class:ResponseTicket/Attribute:impact/Value:1' => 'Uma pessoa',
	'Class:ResponseTicket/Attribute:impact/Value:1+' => '',
	'Class:ResponseTicket/Attribute:impact/Value:2' => 'Um serviço',
	'Class:ResponseTicket/Attribute:impact/Value:2+' => '',
	'Class:ResponseTicket/Attribute:impact/Value:3' => 'Um departamento',
	'Class:ResponseTicket/Attribute:impact/Value:3+' => '',
	'Class:ResponseTicket/Attribute:urgency' => 'Urgente',
	'Class:ResponseTicket/Attribute:urgency+' => '',
	'Class:ResponseTicket/Attribute:urgency/Value:1' => 'Baixo',
	'Class:ResponseTicket/Attribute:urgency/Value:1+' => '',
	'Class:ResponseTicket/Attribute:urgency/Value:2' => 'Médio',
	'Class:ResponseTicket/Attribute:urgency/Value:2+' => '',
	'Class:ResponseTicket/Attribute:urgency/Value:3' => 'Alto',
	'Class:ResponseTicket/Attribute:urgency/Value:3+' => '',
	'Class:ResponseTicket/Attribute:priority' => 'Prioridade',
	'Class:ResponseTicket/Attribute:priority+' => '',
	'Class:ResponseTicket/Attribute:priority/Value:1' => 'Baixo',
	'Class:ResponseTicket/Attribute:priority/Value:1+' => '',
	'Class:ResponseTicket/Attribute:priority/Value:2' => 'Médio',
	'Class:ResponseTicket/Attribute:priority/Value:2+' => '',
	'Class:ResponseTicket/Attribute:priority/Value:3' => 'Alto',
	'Class:ResponseTicket/Attribute:priority/Value:3+' => '',
	'Class:ResponseTicket/Attribute:workgroup_id' => 'Grupo de trabalho',
	'Class:ResponseTicket/Attribute:workgroup_id+' => '',
	'Class:ResponseTicket/Attribute:workgroup_name' => 'Grupo de trabalho',
	'Class:ResponseTicket/Attribute:workgroup_name+' => '',
	'Class:ResponseTicket/Attribute:agent_id' => 'Agente',
	'Class:ResponseTicket/Attribute:agent_id+' => '',
	'Class:ResponseTicket/Attribute:agent_name' => 'Agente',
	'Class:ResponseTicket/Attribute:agent_name+' => '',
	'Class:ResponseTicket/Attribute:agent_email' => 'Email agente',
	'Class:ResponseTicket/Attribute:agent_email+' => '',
	'Class:ResponseTicket/Attribute:related_problem_id' => 'Problema relacionado',
	'Class:ResponseTicket/Attribute:related_problem_id+' => '',
	'Class:ResponseTicket/Attribute:related_problem_ref' => 'Ref',
	'Class:ResponseTicket/Attribute:related_problem_ref+' => '',
	'Class:ResponseTicket/Attribute:related_change_id' => 'Mudanças relacionadas',
	'Class:ResponseTicket/Attribute:related_change_id+' => '',
	'Class:ResponseTicket/Attribute:related_change_ref' => 'Mudanças relacionadas',
	'Class:ResponseTicket/Attribute:related_change_ref+' => '',
	'Class:ResponseTicket/Attribute:close_date' => 'Fechado',
	'Class:ResponseTicket/Attribute:close_date+' => '',
	'Class:ResponseTicket/Attribute:last_update' => 'Última atualização',
	'Class:ResponseTicket/Attribute:last_update+' => '',
	'Class:ResponseTicket/Attribute:assignment_date' => 'Atribuído',
	'Class:ResponseTicket/Attribute:assignment_date+' => '',
	'Class:ResponseTicket/Attribute:resolution_date' => 'Data da Resolução',
	'Class:ResponseTicket/Attribute:resolution_date+' => '',
	'Class:ResponseTicket/Attribute:tto_escalation_deadline' => 'TTO Prazo de escalonamento',
	'Class:ResponseTicket/Attribute:tto_escalation_deadline+' => '',
	'Class:ResponseTicket/Attribute:ttr_escalation_deadline' => 'TTR Prazo de escalonamento',
	'Class:ResponseTicket/Attribute:ttr_escalation_deadline+' => '',
	'Class:ResponseTicket/Attribute:closure_deadline' => 'Prazo fechamento',
	'Class:ResponseTicket/Attribute:closure_deadline+' => '',
	'Class:ResponseTicket/Attribute:resolution_code' => 'Código resolução',
	'Class:ResponseTicket/Attribute:resolution_code+' => '',
	'Class:ResponseTicket/Attribute:resolution_code/Value:couldnotreproduce' => 'Não pode ser reproduzida',
	'Class:ResponseTicket/Attribute:resolution_code/Value:couldnotreproduce+' => '',
	'Class:ResponseTicket/Attribute:resolution_code/Value:duplicate' => 'Ticket duplicado',
	'Class:ResponseTicket/Attribute:resolution_code/Value:duplicate+' => '',
	'Class:ResponseTicket/Attribute:resolution_code/Value:fixed' => 'Fixo',
	'Class:ResponseTicket/Attribute:resolution_code/Value:fixed+' => '',
	'Class:ResponseTicket/Attribute:resolution_code/Value:irrelevant' => 'Irrelevante',
	'Class:ResponseTicket/Attribute:resolution_code/Value:irrelevant+' => '',
	'Class:ResponseTicket/Attribute:solution' => 'Solução',
	'Class:ResponseTicket/Attribute:solution+' => '',
	'Class:ResponseTicket/Attribute:user_satisfaction' => 'Satisfação usuário',
	'Class:ResponseTicket/Attribute:user_satisfaction+' => '',
	'Class:ResponseTicket/Attribute:user_satisfaction/Value:1' => '1',
	'Class:ResponseTicket/Attribute:user_satisfaction/Value:1+' => '1',
	'Class:ResponseTicket/Attribute:user_satisfaction/Value:2' => '2',
	'Class:ResponseTicket/Attribute:user_satisfaction/Value:2+' => '2',
	'Class:ResponseTicket/Attribute:user_satisfaction/Value:3' => '3',
	'Class:ResponseTicket/Attribute:user_satisfaction/Value:3+' => '3',
	'Class:ResponseTicket/Attribute:user_satisfaction/Value:4' => '4',
	'Class:ResponseTicket/Attribute:user_satisfaction/Value:4+' => '4',
	'Class:ResponseTicket/Attribute:user_commment' => 'Comentário usuário',
	'Class:ResponseTicket/Attribute:user_commment+' => '',
	'Class:ResponseTicket/Stimulus:ev_assign' => 'Atribuir',
	'Class:ResponseTicket/Stimulus:ev_assign+' => '',
	'Class:ResponseTicket/Stimulus:ev_reassign' => 'Re-atribuir',
	'Class:ResponseTicket/Stimulus:ev_reassign+' => '',
	'Class:ResponseTicket/Stimulus:ev_timeout' => 'ev_timeout',
	'Class:ResponseTicket/Stimulus:ev_timeout+' => '',
	'Class:ResponseTicket/Stimulus:ev_resolve' => 'Marque como resolvido',
	'Class:ResponseTicket/Stimulus:ev_resolve+' => '',
	'Class:ResponseTicket/Stimulus:ev_close' => 'Fechado',
	'Class:ResponseTicket/Stimulus:ev_close+' => '',
));
?>
