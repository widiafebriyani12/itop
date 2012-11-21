<?php
// Copyright (C) 2010-2012 Combodo SARL
//
//   This file is part of iTop.
//
//   iTop is free software; you can redistribute it and/or modify	
//   it under the terms of the GNU Affero General Public License as published by
//   the Free Software Foundation, either version 3 of the License, or
//   (at your option) any later version.
//
//   iTop is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU Affero General Public License for more details.
//
//   You should have received a copy of the GNU Affero General Public License
//   along with iTop. If not, see <http://www.gnu.org/licenses/>


/**
 * Localized data
 *
 * @copyright   Copyright (C) 2010-2012 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

// Dictionnay conventions
// Class:<class_name>
// Class:<class_name>+
// Class:<class_name>/Attribute:<attribute_code>
// Class:<class_name>/Attribute:<attribute_code>+
// Class:<class_name>/Attribute:<attribute_code>/Value:<value>
// Class:<class_name>/Attribute:<attribute_code>/Value:<value>+
// Class:<class_name>/Stimulus:<stimulus_code>
// Class:<class_name>/Stimulus:<stimulus_code>+

Dict::Add('JA JP', 'Japanese', '日本語', array(
'Menu:ServiceManagement' => 'サービス管理',
'Menu:ServiceManagement+' => 'サービス管理概要',
'Menu:Service:Overview' => '概要',
'Menu:Service:Overview+' => '',
'UI-ServiceManagementMenu-ContractsBySrvLevel' => 'サービスレベル別契約',
'UI-ServiceManagementMenu-ContractsByStatus' => 'ステータス別契約',
'UI-ServiceManagementMenu-ContractsEndingIn30Days' => '30日以内に終了する契約',

'Menu:ServiceType' => 'サービスタイプ',
'Menu:ServiceType+' => 'サービスタイプ',
'Menu:ProviderContract' => 'プロバイダー契約',
'Menu:ProviderContract+' => 'プロバイダー契約',
'Menu:CustomerContract' => '顧客契約',
'Menu:CustomerContract+' => '顧客契約',
'Menu:ServiceSubcategory' => 'サービスサブカテゴリ',
'Menu:ServiceSubcategory+' => 'サービスサブカテゴリ',
'Menu:Service' => 'サービス',
'Menu:Service+' => 'サービス',
'Menu:ServiceElement' => 'サービス要素',
'Menu:ServiceElement+' => 'サービス要素',
'Menu:SLA' => 'SLA',
'Menu:SLA+' => 'サービスレベルアグリーメント',
'Menu:SLT' => 'SLT',
'Menu:SLT+' => 'サービスレベルターゲット',
'Menu:RequestTemplate' => '要求テンプレート',
'Menu:RequestTemplate+' => '全ての要求テンプレート',
'Menu:DeliveryModel' => '提供モデル',
'Menu:DeliveryModel+' => '提供モデル',
'Menu:ServiceFamily' => 'サービスファミリ',
'Menu:ServiceFamily+' => 'サービスファミリ',
'Menu:Procedure' => '手順カタログ',
'Menu:Procedure+' => '全ての手順カタログ',



));


//
// Class: ContractType
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:ContractType' => '契約タイプ',
	'Class:ContractType+' => '',
));

//
// Class: Contract
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:Contract' => '契約',
	'Class:Contract+' => '',
	'Class:Contract/Attribute:name' => '名前',
	'Class:Contract/Attribute:name+' => '',
	'Class:Contract/Attribute:org_id' => '顧客',
	'Class:Contract/Attribute:org_id+' => '',
	'Class:Contract/Attribute:organization_name' => '顧客名',
	'Class:Contract/Attribute:organization_name+' => '共通の名前',
	'Class:Contract/Attribute:contacts_list' => '連絡先',
	'Class:Contract/Attribute:contacts_list+' => '',
	'Class:Contract/Attribute:documents_list' => '文書',
	'Class:Contract/Attribute:documents_list+' => '',
	'Class:Contract/Attribute:description' => '説明',
	'Class:Contract/Attribute:description+' => '',
	'Class:Contract/Attribute:start_date' => '開始日',
	'Class:Contract/Attribute:start_date+' => '',
	'Class:Contract/Attribute:end_date' => '終了日',
	'Class:Contract/Attribute:end_date+' => '',
	'Class:Contract/Attribute:cost' => '費用',
	'Class:Contract/Attribute:cost+' => '',
	'Class:Contract/Attribute:cost_currency' => '費用通貨',
	'Class:Contract/Attribute:cost_currency+' => '',
	'Class:Contract/Attribute:cost_currency/Value:dollars' => '米ドル',
	'Class:Contract/Attribute:cost_currency/Value:dollars+' => '',
	'Class:Contract/Attribute:cost_currency/Value:euros' => 'ユーロ',
	'Class:Contract/Attribute:cost_currency/Value:euros+' => '',
	'Class:Contract/Attribute:contracttype_id' => '契約タイプ',
	'Class:Contract/Attribute:contracttype_id+' => '',
	'Class:Contract/Attribute:contracttype_name' => '契約タイプ名',
	'Class:Contract/Attribute:contracttype_name+' => '',
	'Class:Contract/Attribute:billing_frequency' => '課金頻度',
	'Class:Contract/Attribute:billing_frequency+' => '',
	'Class:Contract/Attribute:cost_unit' => '費用単位',
	'Class:Contract/Attribute:cost_unit+' => '',
	'Class:Contract/Attribute:provider_id' => 'プロバイダー',
	'Class:Contract/Attribute:provider_id+' => '',
	'Class:Contract/Attribute:provider_name' => 'プロバイダー名',
	'Class:Contract/Attribute:provider_name+' => '共通名',
	'Class:Contract/Attribute:status' => '状態',
	'Class:Contract/Attribute:status+' => '',
	'Class:Contract/Attribute:status/Value:implementation' => '実装',
	'Class:Contract/Attribute:status/Value:implementation+' => '実装',
	'Class:Contract/Attribute:status/Value:obsolete' => '廃止',
	'Class:Contract/Attribute:status/Value:obsolete+' => '廃止',
	'Class:Contract/Attribute:status/Value:production' => '稼働',
	'Class:Contract/Attribute:status/Value:production+' => '稼働',
	'Class:Contract/Attribute:finalclass' => 'タイプ',
	'Class:Contract/Attribute:finalclass+' => '',
));
//
// Class: CustomerContract
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:CustomerContract' => '顧客契約',
	'Class:CustomerContract+' => '',
	'Class:CustomerContract/Attribute:services_list' => 'サービス',
	'Class:CustomerContract/Attribute:services_list+' => '',
));

//
// Class: ProviderContract
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:ProviderContract' => 'プロバイダー契約',
	'Class:ProviderContract+' => '',
	'Class:ProviderContract/Attribute:functionalcis_list' => 'CI',
	'Class:ProviderContract/Attribute:functionalcis_list+' => '',
	'Class:ProviderContract/Attribute:sla' => 'SLA',
	'Class:ProviderContract/Attribute:sla+' => 'サービスレベルアグリーメント',
	'Class:ProviderContract/Attribute:coverage' => 'サービス時間帯',
	'Class:ProviderContract/Attribute:coverage+' => '',
	'Class:ProviderContract/Attribute:contracttype_id' => '契約タイプ',
	'Class:ProviderContract/Attribute:contracttype_id+' => '',
	'Class:ProviderContract/Attribute:contracttype_name' => '契約タイプ名',
	'Class:ProviderContract/Attribute:contracttype_name+' => '',
));

//
// Class: lnkContactToContract
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:lnkContactToContract' => 'リンク 連絡先/契約',
	'Class:lnkContactToContract+' => '',
	'Class:lnkContactToContract/Attribute:contract_id' => '契約',
	'Class:lnkContactToContract/Attribute:contract_id+' => '',
	'Class:lnkContactToContract/Attribute:contract_name' => '契約名',
	'Class:lnkContactToContract/Attribute:contract_name+' => '',
	'Class:lnkContactToContract/Attribute:contact_id' => '連絡先',
	'Class:lnkContactToContract/Attribute:contact_id+' => '',
	'Class:lnkContactToContract/Attribute:contact_name' => '連絡先名',
	'Class:lnkContactToContract/Attribute:contact_name+' => '',
));

//
// Class: lnkContractToDocument
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:lnkContractToDocument' => 'リンク 契約/文書',
	'Class:lnkContractToDocument+' => '',
	'Class:lnkContractToDocument/Attribute:contract_id' => '契約',
	'Class:lnkContractToDocument/Attribute:contract_id+' => '',
	'Class:lnkContractToDocument/Attribute:contract_name' => '契約名',
	'Class:lnkContractToDocument/Attribute:contract_name+' => '',
	'Class:lnkContractToDocument/Attribute:document_id' => '文書',
	'Class:lnkContractToDocument/Attribute:document_id+' => '',
	'Class:lnkContractToDocument/Attribute:document_name' => '文書名',
	'Class:lnkContractToDocument/Attribute:document_name+' => '',
));

//
// Class: lnkFunctionalCIToProviderContract
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:lnkFunctionalCIToProviderContract' => 'リンク 機能的CI/プロバイダー契約',
	'Class:lnkFunctionalCIToProviderContract+' => '',
	'Class:lnkFunctionalCIToProviderContract/Attribute:providercontract_id' => 'プロバイダー契約',
	'Class:lnkFunctionalCIToProviderContract/Attribute:providercontract_id+' => '',
	'Class:lnkFunctionalCIToProviderContract/Attribute:providercontract_name' => 'プロバイダー契約名',
	'Class:lnkFunctionalCIToProviderContract/Attribute:providercontract_name+' => '',
	'Class:lnkFunctionalCIToProviderContract/Attribute:functionalci_id' => 'CI',
	'Class:lnkFunctionalCIToProviderContract/Attribute:functionalci_id+' => '',
	'Class:lnkFunctionalCIToProviderContract/Attribute:functionalci_name' => 'CI名',
	'Class:lnkFunctionalCIToProviderContract/Attribute:functionalci_name+' => '',
));

//
// Class: ServiceFamily
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:ServiceFamily' => 'サービスファミリ',
	'Class:ServiceFamily+' => '',
	'Class:ServiceFamily/Attribute:name' => '名前',
	'Class:ServiceFamily/Attribute:name+' => '',
	'Class:ServiceFamily/Attribute:services_list' => 'サービス',
	'Class:ServiceFamily/Attribute:services_list+' => '',
));

//
// Class: Service
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:Service' => 'サービス',
	'Class:Service+' => '',
	'Class:Service/Attribute:name' => '名前',
	'Class:Service/Attribute:name+' => '',
	'Class:Service/Attribute:org_id' => 'プロバイダー',
	'Class:Service/Attribute:org_id+' => '',
	'Class:Service/Attribute:organization_name' => 'プロバイダー名',
	'Class:Service/Attribute:organization_name+' => '',
	'Class:Service/Attribute:servicefamily_id' => 'サービスファミリ',
	'Class:Service/Attribute:servicefamily_id+' => '',
	'Class:Service/Attribute:servicefamily_name' => 'サービスファミリ名',
	'Class:Service/Attribute:servicefamily_name+' => '',
	'Class:Service/Attribute:description' => '説明',
	'Class:Service/Attribute:description+' => '',
	'Class:Service/Attribute:documents_list' => '文書',
	'Class:Service/Attribute:documents_list+' => '',
	'Class:Service/Attribute:contacts_list' => '連絡先',
	'Class:Service/Attribute:contacts_list+' => '',
	'Class:Service/Attribute:status' => '状態',
	'Class:Service/Attribute:status+' => '',
	'Class:Service/Attribute:status/Value:implementation' => '実装中',
	'Class:Service/Attribute:status/Value:implementation+' => '実装中',
	'Class:Service/Attribute:status/Value:obsolete' => '廃止済み',
	'Class:Service/Attribute:status/Value:obsolete+' => '',
	'Class:Service/Attribute:status/Value:production' => '稼働中',
	'Class:Service/Attribute:status/Value:production+' => '',
	'Class:Service/Attribute:customercontracts_list' => '顧客契約',
	'Class:Service/Attribute:customercontracts_list+' => '',
	'Class:Service/Attribute:providercontracts_list' => 'プロバイダー契約',
	'Class:Service/Attribute:providercontracts_list+' => '',
	'Class:Service/Attribute:functionalcis_list' => '依存するCI',
	'Class:Service/Attribute:functionalcis_list+' => '',
	'Class:Service/Attribute:servicesubcategories_list' => 'サービスサブカテゴリ',
	'Class:Service/Attribute:servicesubcategories_list+' => '',
));

//
// Class: lnkDocumentToService
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:lnkDocumentToService' => 'リンク 文書/サービス',
	'Class:lnkDocumentToService+' => '',
	'Class:lnkDocumentToService/Attribute:service_id' => 'サービス',
	'Class:lnkDocumentToService/Attribute:service_id+' => '',
	'Class:lnkDocumentToService/Attribute:service_name' => 'サービス名',
	'Class:lnkDocumentToService/Attribute:service_name+' => '',
	'Class:lnkDocumentToService/Attribute:document_id' => '文書',
	'Class:lnkDocumentToService/Attribute:document_id+' => '',
	'Class:lnkDocumentToService/Attribute:document_name' => '文書名',
	'Class:lnkDocumentToService/Attribute:document_name+' => '',
));

//
// Class: lnkContactToService
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:lnkContactToService' => 'リンク 連絡先/サービス',
	'Class:lnkContactToService+' => '',
	'Class:lnkContactToService/Attribute:service_id' => 'サービス',
	'Class:lnkContactToService/Attribute:service_id+' => '',
	'Class:lnkContactToService/Attribute:service_name' => 'サービス名',
	'Class:lnkContactToService/Attribute:service_name+' => '',
	'Class:lnkContactToService/Attribute:contact_id' => '連絡先',
	'Class:lnkContactToService/Attribute:contact_id+' => '',
	'Class:lnkContactToService/Attribute:contact_name' => '連絡先名',
	'Class:lnkContactToService/Attribute:contact_name+' => '',
));

//
// Class: ServiceSubcategory
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:ServiceSubcategory' => 'サービスサブカテゴリ',
	'Class:ServiceSubcategory+' => '',
	'Class:ServiceSubcategory/Attribute:name' => '名前',
	'Class:ServiceSubcategory/Attribute:name+' => '',
	'Class:ServiceSubcategory/Attribute:description' => '説明',
	'Class:ServiceSubcategory/Attribute:description+' => '',
	'Class:ServiceSubcategory/Attribute:service_id' => 'サービス',
	'Class:ServiceSubcategory/Attribute:service_id+' => '',
	'Class:ServiceSubcategory/Attribute:service_name' => 'サービス名',
	'Class:ServiceSubcategory/Attribute:service_name+' => '',
	'Class:ServiceSubcategory/Attribute:request_type' => '要求タイプ',
	'Class:ServiceSubcategory/Attribute:request_type+' => '',
	'Class:ServiceSubcategory/Attribute:request_type/Value:incident' => 'インシデント',
	'Class:ServiceSubcategory/Attribute:request_type/Value:incident+' => 'インシデント',
	'Class:ServiceSubcategory/Attribute:request_type/Value:service_request' => 'サービス要求',
	'Class:ServiceSubcategory/Attribute:request_type/Value:service_request+' => 'サービス要求',
	'Class:ServiceSubcategory/Attribute:status' => '状態',
	'Class:ServiceSubcategory/Attribute:status+' => '',
	'Class:ServiceSubcategory/Attribute:status/Value:implementation' => '実装中',
	'Class:ServiceSubcategory/Attribute:status/Value:implementation+' => '実装中',
	'Class:ServiceSubcategory/Attribute:status/Value:obsolete' => '廃止済み',
	'Class:ServiceSubcategory/Attribute:status/Value:obsolete+' => '廃止済み',
	'Class:ServiceSubcategory/Attribute:status/Value:production' => '稼働中',
	'Class:ServiceSubcategory/Attribute:status/Value:production+' => '稼働中',
));

//
// Class: SLA
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:SLA' => 'SLA',
	'Class:SLA+' => '',
	'Class:SLA/Attribute:name' => '名前',
	'Class:SLA/Attribute:name+' => '',
	'Class:SLA/Attribute:description' => '説明',
	'Class:SLA/Attribute:description+' => '',
	'Class:SLA/Attribute:org_id' => 'プロバイダ',
	'Class:SLA/Attribute:org_id+' => '',
	'Class:SLA/Attribute:organization_name' => 'プロバイダ名',
	'Class:SLA/Attribute:organization_name+' => '共通名',
	'Class:SLA/Attribute:slts_list' => 'SLT',
	'Class:SLA/Attribute:slts_list+' => '',
	'Class:SLA/Attribute:customercontracts_list' => '顧客連絡先',
	'Class:SLA/Attribute:customercontracts_list+' => '',
));

//
// Class: SLT
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:SLT' => 'SLT',
	'Class:SLT+' => '',
	'Class:SLT/Attribute:name' => '名前',
	'Class:SLT/Attribute:name+' => '',
	'Class:SLT/Attribute:priority' => '優先度',
	'Class:SLT/Attribute:priority+' => '',
	'Class:SLT/Attribute:priority/Value:1' => '最優先',
	'Class:SLT/Attribute:priority/Value:1+' => '最優先',
	'Class:SLT/Attribute:priority/Value:2' => '高',
	'Class:SLT/Attribute:priority/Value:2+' => '高',
	'Class:SLT/Attribute:priority/Value:3' => '中',
	'Class:SLT/Attribute:priority/Value:3+' => '中',
	'Class:SLT/Attribute:priority/Value:4' => '低',
	'Class:SLT/Attribute:priority/Value:4+' => '低',
	'Class:SLT/Attribute:request_type' => '要求タイプ',
	'Class:SLT/Attribute:request_type+' => '',
	'Class:SLT/Attribute:request_type/Value:incident' => 'インシデント',
	'Class:SLT/Attribute:request_type/Value:incident+' => 'インシデント',
	'Class:SLT/Attribute:request_type/Value:servicerequest' => 'サービス要求',
	'Class:SLT/Attribute:request_type/Value:servicerequest+' => 'サービス要求',
	'Class:SLT/Attribute:metric' => 'メトリック',
	'Class:SLT/Attribute:metric+' => '',
	'Class:SLT/Attribute:metric/Value:tto' => 'TTO',
	'Class:SLT/Attribute:metric/Value:tto+' => 'TTO',
	'Class:SLT/Attribute:metric/Value:ttr' => 'TTR',
	'Class:SLT/Attribute:metric/Value:ttr+' => 'TTR',
	'Class:SLT/Attribute:value' => '値',
	'Class:SLT/Attribute:value+' => '',
	'Class:SLT/Attribute:unit' => '単位',
	'Class:SLT/Attribute:unit+' => '',
	'Class:SLT/Attribute:unit/Value:hours' => '時間',
	'Class:SLT/Attribute:unit/Value:hours+' => '時間',
	'Class:SLT/Attribute:unit/Value:minutes' => '分',
	'Class:SLT/Attribute:unit/Value:minutes+' => '分',
));

//
// Class: lnkSLAToSLT
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:lnkSLAToSLT' => 'リンク SLA / SLT',
	'Class:lnkSLAToSLT+' => '',
	'Class:lnkSLAToSLT/Attribute:sla_id' => 'SLA',
	'Class:lnkSLAToSLT/Attribute:sla_id+' => '',
	'Class:lnkSLAToSLT/Attribute:sla_name' => 'SLA名',
	'Class:lnkSLAToSLT/Attribute:sla_name+' => '',
	'Class:lnkSLAToSLT/Attribute:slt_id' => 'SLT',
	'Class:lnkSLAToSLT/Attribute:slt_id+' => '',
	'Class:lnkSLAToSLT/Attribute:slt_name' => 'SLT名',
	'Class:lnkSLAToSLT/Attribute:slt_name+' => '',
));

//
// Class: lnkCustomerContractToService
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:lnkCustomerContractToService' => 'リンク 顧客契約/サービス',
	'Class:lnkCustomerContractToService+' => '',
	'Class:lnkCustomerContractToService/Attribute:customercontract_id' => '顧客契約',
	'Class:lnkCustomerContractToService/Attribute:customercontract_id+' => '',
	'Class:lnkCustomerContractToService/Attribute:customercontract_name' => '顧客契約名',
	'Class:lnkCustomerContractToService/Attribute:customercontract_name+' => '',
	'Class:lnkCustomerContractToService/Attribute:service_id' => 'サービス',
	'Class:lnkCustomerContractToService/Attribute:service_id+' => '',
	'Class:lnkCustomerContractToService/Attribute:service_name' => 'サービス名',
	'Class:lnkCustomerContractToService/Attribute:service_name+' => '',
	'Class:lnkCustomerContractToService/Attribute:sla_id' => 'SLA',
	'Class:lnkCustomerContractToService/Attribute:sla_id+' => '',
	'Class:lnkCustomerContractToService/Attribute:sla_name' => 'SLA名',
	'Class:lnkCustomerContractToService/Attribute:sla_name+' => '',
));

//
// Class: lnkProviderContractToService
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:lnkProviderContractToService' => 'リンク プロバイダ契約/サービス',
	'Class:lnkProviderContractToService+' => '',
	'Class:lnkProviderContractToService/Attribute:service_id' => 'サービス',
	'Class:lnkProviderContractToService/Attribute:service_id+' => '',
	'Class:lnkProviderContractToService/Attribute:service_name' => 'サービス名',
	'Class:lnkProviderContractToService/Attribute:service_name+' => '',
	'Class:lnkProviderContractToService/Attribute:providercontract_id' => 'プロバイダ契約',
	'Class:lnkProviderContractToService/Attribute:providercontract_id+' => '',
	'Class:lnkProviderContractToService/Attribute:providercontract_name' => 'プロバイダ契約名',
	'Class:lnkProviderContractToService/Attribute:providercontract_name+' => '',
));

//
// Class: lnkFunctionalCIToService
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:lnkFunctionalCIToService' => 'リンク 機能的CI/サービス',
	'Class:lnkFunctionalCIToService+' => '',
	'Class:lnkFunctionalCIToService/Attribute:service_id' => 'サービス',
	'Class:lnkFunctionalCIToService/Attribute:service_id+' => '',
	'Class:lnkFunctionalCIToService/Attribute:service_name' => 'サービス名',
	'Class:lnkFunctionalCIToService/Attribute:service_name+' => '',
	'Class:lnkFunctionalCIToService/Attribute:functionalci_id' => 'CI',
	'Class:lnkFunctionalCIToService/Attribute:functionalci_id+' => '',
	'Class:lnkFunctionalCIToService/Attribute:functionalci_name' => 'CI名',
	'Class:lnkFunctionalCIToService/Attribute:functionalci_name+' => '',
));

//
// Class: DeliveryModel
//

Dict::Add('EN US', 'English', 'English', array(
	'Class:DeliveryModel' => '提供モデル',
	'Class:DeliveryModel+' => '',
	'Class:DeliveryModel/Attribute:name' => '名前',
	'Class:DeliveryModel/Attribute:name+' => '',
	'Class:DeliveryModel/Attribute:org_id' => '組織',
	'Class:DeliveryModel/Attribute:org_id+' => '',
	'Class:DeliveryModel/Attribute:organization_name' => '組織名',
	'Class:DeliveryModel/Attribute:organization_name+' => '共通名',
	'Class:DeliveryModel/Attribute:description' => '説明',
	'Class:DeliveryModel/Attribute:description+' => '',
	'Class:DeliveryModel/Attribute:contacts_list' => '連絡先',
	'Class:DeliveryModel/Attribute:contacts_list+' => '',
	'Class:DeliveryModel/Attribute:customers_list' => '顧客',
	'Class:DeliveryModel/Attribute:customers_list+' => '',
));

//
// Class: lnkDeliveryModelToContact
//

Dict::Add('JA JP', 'Japanese', '日本語', array(
	'Class:lnkDeliveryModelToContact' => 'Link 提供モデル/連絡先',
	'Class:lnkDeliveryModelToContact+' => '',
	'Class:lnkDeliveryModelToContact/Attribute:deliverymodel_id' => '提供モデル',
	'Class:lnkDeliveryModelToContact/Attribute:deliverymodel_id+' => '',
	'Class:lnkDeliveryModelToContact/Attribute:deliverymodel_name' => '提供モデル名',
	'Class:lnkDeliveryModelToContact/Attribute:deliverymodel_name+' => '',
	'Class:lnkDeliveryModelToContact/Attribute:contact_id' => '連絡先',
	'Class:lnkDeliveryModelToContact/Attribute:contact_id+' => '',
	'Class:lnkDeliveryModelToContact/Attribute:contact_name' => '連絡先名',
	'Class:lnkDeliveryModelToContact/Attribute:contact_name+' => '',
	'Class:lnkDeliveryModelToContact/Attribute:role_id' => '役割',
	'Class:lnkDeliveryModelToContact/Attribute:role_id+' => '',
	'Class:lnkDeliveryModelToContact/Attribute:role_name' => '役割名',
	'Class:lnkDeliveryModelToContact/Attribute:role_name+' => '',
));


?>
