const constantsComponent = {
	install: (app, options) => {
		app.config.globalProperties.$constComponent = {
			ICON_SPINNER: ['fas', 'spinner']


		},
        app.config.globalProperties.$constGrid = {
            ID_NAME: 'idPk',
            ICON_CLASS: 'fas',
            ICON_PRINT:  {fawIcon:'fas', icon: 'print', color: "darkgreen"},
            ICON_EDIT:   {fawIcon:'fas', icon: 'edit',  color: "darkblue"},
            ICON_DELETE: {fawIcon:'fas', icon: 'times', color: "darkred"},
	        ICON_UP_ORDER: {fawIcon:'fas', icon: 'caret-up', color: null},
	        ICON_DOWN_ORDER: {fawIcon:'fas', icon: 'caret-down', color: null},
            ICON_ORDER: {fawIcon:'fas', icon: 'sort', color: null},
            ICON_FILTER: {fawIcon:'fas', icon: 'ellipsis-v', color: null},
            ORDER_ASC: 'asc',
            ORDER_DESC: 'desc',
	        SQL_UPDATE: 'update',
	        SQL_UPDATE_DELETE: 'updateDelete',
	        SQL_INSERT: 'insert',
	        SQL_DELETE: 'delete',
            getIcon: function (fawIcon, icon, color) {
                return {fawIcon:fawIcon, icon: icon, color: color}
            },
            HEADER: {
                CAPTION_TYPE_FIELD: 'field'  ,
                CAPTION_TYPE_ACTION: 'action',
                TABLE_FIELD_NAME: 'tableFieldName',
                getHeader: function (id, caption, width, tableFieldName, type, orderBy, defaultOrder, filterBy) {

                	if(type == this.CAPTION_TYPE_ACTION){
		                orderBy = false;
                        defaultOrder = false;
		                filterBy = false;
	                }

                	if(!orderBy){
                	    defaultOrder = false;
                    }

                    return {id: id, caption: caption,   width: width,  tableFieldName: tableFieldName,  type: type, orderBy: {order: orderBy, defaultOrder: defaultOrder}, filterBy: filterBy};
                }
            },
            BODY:{
                FIELD_NAME: 'fieldName'
            },
            getActionButton: function (id, tooltip, emitAction, icon) {
                return {id: id, tooltip: tooltip, emitAction: emitAction, icon: icon };
            },
            getOrderByReactive: function (id, order, fieldName) {
                 return {id: id, order: order, fieldName: fieldName};
            },
	        getFilterByReactive: function (id, fieldName, filterString, showInputDiv, type, iconColor) {
		        return {id: id, fieldName: fieldName, filterString: filterString, showInputDiv: showInputDiv, type: type, iconColor: iconColor};
	        }
        }
    }
}

export default constantsComponent;
