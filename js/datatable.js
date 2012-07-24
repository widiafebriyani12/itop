// jQuery UI style "widget" for selecting and sorting "fields"
$(function()
{
	// the widget definition, where "itop" is the namespace,
	// "datatable" the widget name
	$.widget( "itop.datatable",
	{
		// default options
		options:
		{
			sPersistentId: '',
			sFilter: '',
			oColumns: {},
			sSelectMode: '',
			sViewLink: 'true',
			iNbObjects: 0,
			iDefaultPageSize: -1,
			iPageSize: -1,
			iPageIndex: 0,
			oClassAliases: {},
			sTableId : null,
			oExtraParams: {},
			sRenderUrl: 'index.php',
			oRenderParameters: {},
			oDefaultSettings: {},
			oLabels: { moveup: 'Move Up', movedown: 'Move Down' }
		},
	
		// the constructor
		_create: function()
		{
			this.aDlgStateParams = ['iDefaultPageSize', 'oColumns'];

			this.element
			.addClass('itop-datatable');
			
			var me = this;
			var sId = new String(this.element.attr('id'));
			var sListId = sId.replace('datatable_', '');
			var bViewLink = (this.options.sViewLink == 'true');
			$('#sfl_'+sListId).fieldsorter({hasKeyColumn: bViewLink, labels: this.options.oLabels, fields: this.options.oColumns, onChange: function() { me._onSpecificSettings(); } });
			$('#datatable_dlg_'+sListId).find('input[name=page_size]').click(function() { me._onSpecificSettings(); });
			$('#datatable_dlg_'+sListId).find('input[name=save_settings]').click(function() { me._updateSaveScope(); });
			this.element.find('.itop_popup > ul li').popupmenu();
			this._updateSaveScope();
			this._saveDlgState();
		},
	
		// called when created, and later when changing options
		_refresh: function()
		{
			oParams = this.options.oRenderParameters;
			oParams.operation = 'datatable';
			
			oParams.filter = this.options.sFilter;
			oParams.extra_param = this.options.oExtraParams;
			oParams.start = 0;
			oParams.end = this.options.iPageSize;
			oParams.select_mode = this.options.sSelectMode;
			oParams.display_key = this.options.sViewLink;
			oParams.class_aliases = this.options.oClassAliases;
			oParams.columns = this.options.oColumns;
			
			var sId = new String(this.element.attr('id'));
			var sListId = sId.replace('datatable_', '');
			oParams.list_id = sListId;
			var me = this;
			$.post(this.options.sRenderUrl, oParams, function(data) {
				// Nasty workaround to clear the pager's state for paginated lists !!!
				// See jquery.tablesorter.pager.js / saveParams / restoreParams
				if (window.pager_params)
				{
					window.pager_params['pager'+sListId] = undefined;
				}
				// End of workaround

				me.element.find('.datacontents').html(data);
			}, 'html' );
			
		},
		_useDefaultSettings: function(bResetAll)
		{
			var oParams = this.options.oRenderParameters;
			oParams.operation = 'datatable_reset_settings';
			
			oParams.table_id = this.options.sTableId;
			oParams.defaults = bResetAll;
			oParams.class_aliases = this.options.oClassAliases;
			
			var me = this;
			$.post(this.options.sRenderUrl, oParams, function(data) {
				// Do nothing...
			}, 'html' );			
		},
		_saveSettings: function(bSaveAsDefaults)
		{
			var oParams = this.options.oRenderParameters;
			oParams.operation = 'datatable_save_settings';
			
			oParams.page_size = this.options.iPageSize;
			oParams.table_id = this.options.sTableId;
			oParams.defaults = bSaveAsDefaults;
			oParams.class_aliases = this.options.oClassAliases;
			oParams.columns = this.options.oColumns;
			
			var me = this;
			$.post(this.options.sRenderUrl, oParams, function(data) {
				// Do nothing...
			}, 'html' );
		},
		onDlgOk: function()
		{
			var oOptions = {};
			var sId = new String(this.element.attr('id'));
			var sListId = sId.replace('datatable_', '');
			oSettings = $('#datatable_dlg_'+sListId).find('input[name=settings]:checked');
			if (oSettings.val() == 'defaults')
			{
				oOptions = { iPageSize: this.options.oDefaultSettings.iDefaultPageSize, 
							 oColumns: this.options.oDefaultSettings.oColumns,
						   };
			}
			else
			{
				var oDisplayColumns = {};
				var iColIdx = 0;
				var iSortIdx = 0;
				var sSortDirection = 'asc';
				var oColumns = $('#datatable_dlg_'+sListId).find(':itop-fieldsorter').fieldsorter('get_params');
				var iPageSize = $('#datatable_dlg_'+sListId+' input[name=page_size]').val();
				
				oOptions = {oColumns: oColumns, iPageSize: iPageSize };
			}
			this._setOptions(oOptions);
			
			// Check if we need to save the settings or not...
			var oSaveCheck = $('#datatable_dlg_'+sListId).find('input[name=save_settings]');
			var oSaveScope = $('#datatable_dlg_'+sListId).find('input[name=scope]:checked');
			if (oSaveCheck.attr('checked'))
			{
				if (oSettings.val() == 'defaults')
				{
					this._useDefaultSettings((oSaveScope.val() == 'defaults'));					
				}
				else
				{
					this._saveSettings((oSaveScope.val() == 'defaults'));
				}
			}
			this._saveDlgState();
		},
		onDlgCancel: function()
		{
			this._restoreDlgState();
		},
		_onSpecificSettings: function()
		{
			var sId = new String(this.element.attr('id'));
			var sListId = sId.replace('datatable_', '');
			$('#datatable_dlg_'+sListId).find('input.specific_settings').attr('checked', 'checked');
		},
		_updateSaveScope: function()
		{
			var sId = new String(this.element.attr('id'));
			var sListId = sId.replace('datatable_', '');
			var oSaveCheck = $('#datatable_dlg_'+sListId).find('input[name=save_settings]');
			if (oSaveCheck.attr('checked'))
			{
				$('#datatable_dlg_'+sListId).find('input[name=scope]').removeAttr('disabled');
			}
			else
			{
				$('#datatable_dlg_'+sListId).find('input[name=scope]').attr('disabled', 'disabled');
			}
		},
		// events bound via _bind are removed automatically
		// revert other modifications here
		destroy: function()
		{
			this.element
			.removeClass('itop-datatable');
			
			var sId = new String(this.element.attr('id'));
			var sListId = sId.replace('datatable_', '');
			$('#sfl_'+sListId).remove();
			
			// call the original destroy method since we overwrote it
			$.Widget.prototype.destroy.call( this );			
		},
		// _setOptions is called with a hash of all options that are changing
		_setOptions: function()
		{
			// in 1.9 would use _superApply
			$.Widget.prototype._setOptions.apply( this, arguments );
			this._refresh();
		},
		// _setOption is called for each individual option that is changing
		_setOption: function( key, value )
		{
			// in 1.9 would use _super
			$.Widget.prototype._setOption.call( this, key, value );
		},
		_saveDlgState: function()
		{
			this.originalState = {};
			for(k in this.aDlgStateParams)
			{
				this.originalState[this.aDlgStateParams[k]] = this.options[this.aDlgStateParams[k]];
			}
			var sId = new String(this.element.attr('id'));
			var sListId = sId.replace('datatable_', '');
			this.originalState.oFields = $('#datatable_dlg_'+sListId).find(':itop-fieldsorter').fieldsorter('get_params');
		},
		_restoreDlgState: function()
		{
			var sId = new String(this.element.attr('id'));
			var sListId = sId.replace('datatable_', '');
			var dlgElement = $('#datatable_dlg_'+sListId);

			for(k in this.aDlgStateParams)
			{
				this._setOption(this.aDlgStateParams[k], this.originalState[this.aDlgStateParams[k]]);
			}
			
			dlgElement.find('input[name=page_size]').val(this.originalState.iDefaultPageSize);
			
			dlgElement.find(':itop-fieldsorter').fieldsorter('option', { fields: this.originalState.oFields });
		}
	});	
});