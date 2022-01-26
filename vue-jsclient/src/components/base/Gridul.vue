<template>
    <div class="ff-grid-container" :ref=this.REF_DIV_CONTAINER>

        <div class = "ff-grid-loading-modal" v-if="this.showModalLoadingDiv">
            <div>
                <font-awesome-icon :icon=this.$constComponent.ICON_SPINNER size="4x" spin/>
            </div>
        </div>

        <div class="ff-grid" :ref=this.REF_DIV_TABLE>
            <table class="ff-table" :ref=REF_TABLE>
                <thead class="ff-thead" :ref=this.REF_THEAD>
                    <tr :idPk="-1">
                        <template v-for="ph in pConfig.header">
                            <th :id=ph.id v-if="ph.type == 'field'" class="th th--left-align">
                                <div class="divHeader">
                                    <div class="divCaptionFilter">
                                        <div v-if="ph.filterBy" class="divFilter" >
                                            <my-button @click="this.privateShowFilterDiv($event)" :heightButton=22 :buttonType=1 :style="privateShowMarkFilter(ph.id)" :title="'filter...'">
                                                <font-awesome-icon :icon=this.cfgIconPictureAction(this.$constGrid.ICON_FILTER) size="1x"/>
                                            </my-button>
                                        </div>
                                        <div class="divCaption" :title=ph.caption>
                                            {{ph.caption}}
                                        </div>

                                        <div v-if="ph.filterBy" class="divDataFilter" v-bind:class="{ divDataFilterDisplayOn: this.privateReactiveShowFilterDiv(ph.id)}">
                                            <my-input-field :size=20
                                                           :pPlaceHolder="'...'" v-on:keyup="privateKeyPresFilter">
                                            </my-input-field>

                                            <my-button @click="this.privateClearFilter($event)" :heightButton=22 :buttonType=1 title="clear filter" :style="cfgIconColor(this.$constGrid.ICON_DELETE.color)">
                                                <font-awesome-icon :icon=this.cfgIconPictureAction(this.$constGrid.ICON_DELETE) size="1x"/>
                                            </my-button>


                                        </div>

                                    </div>

                                    <div v-if="ph.orderBy.order" class="divOrder">
                                        <my-button :idheader="ph.id"  @click="this.privateOrderBy($event)" :heightButton=22 :buttonType=1 :style="cfgIconColor('white')" :title="'order ...'">
                                            <font-awesome-icon v-if="this.privateIconOrderBy(ph.id) == 1" :icon=this.cfgIconPictureAction(this.$constGrid.ICON_UP_ORDER) size="1x" />
                                            <font-awesome-icon v-if="this.privateIconOrderBy(ph.id) == 2" :icon=this.cfgIconPictureAction(this.$constGrid.ICON_DOWN_ORDER) size="1x" />
                                            <font-awesome-icon v-if="this.privateIconOrderBy(ph.id) == 0" :icon=this.cfgIconPictureAction(this.$constGrid.ICON_ORDER) size="1x" />

                                        </my-button>
                                    </div>

                                </div>
                            </th>
                            <th :id=ph.id v-if="ph.type !== 'field'" class="th th--center-align">
                                <div class="divCaption" :title=ph.caption>
                                    {{ph.caption}}
                                </div>
                            </th>
                        </template>
                     </tr>
                </thead>
                <tbody class="ff-tbody" :ref=REF_TABLE_BODY>
                    <tr v-for="(tr, index) in this.paginate.pag.data" :idPk="tr.id" v-on:keydown.prevent="cfgKeyNavigate($event)" v-on:click.prevent="cfgMouseNavigate($event)" v-bind:key="index">
                        <template v-for="(td, index) in tr" v-bind:key="index">
                            <td v-if="checkFieldHeader(index)" :tabindex=this.cfgGetTabIndex() >
                                <div class="div--left-align " :style="cgfTDStyle(index)" :title="td" :fieldName="index">{{td}}</div>
                            </td>
                        </template>

                        <td :tabindex=this.cfgGetTabIndex()>
                            <div class="div--center-align-action-group" >
                                <div class="toolbar-icon-inline" >
                                    <template v-for="ph in pConfig.actionButtonHeader">
                                       <div class="divButton">
                                           <my-button @click="this.emitAction($event, ph.emitAction)" :heightButton=22 :buttonType=1 :title="ph.tooltip" :style=cfgIconColor(ph.icon.color)>
                                               <font-awesome-icon :icon=this.cfgIconPictureAction(ph.icon) size="1x"/>
                                           </my-button>
                                       </div>
                                    </template>
                                </div>
                            </div>
                        </td>

                    </tr>
                </tbody>
                <tfoot></tfoot>
            </table>

        </div>


        <div class="toolbar">
            <div class="toolbarButton"  v-if="pConfig.toolbar.show" :ref=this.REF_TOOLBAR >

                <template v-for="ph in pConfig.toolbar.actionButton">
                    <div class="divButton">
                        <my-button @click="this.emitActionToolbar($event, ph.emitAction)" :heightButton=22 :buttonType=2 :title="ph.tooltip" :style=cfgIconColor(ph.icon.color)>
                            <font-awesome-icon :icon=this.cfgIconPictureAction(ph.icon) size="1x"/>
                        </my-button>
                    </div>
                </template>


                <div class="dataSelected" :title=this.showSelectedData>{{this.showSelectedData}}</div>

            </div>
        </div>


        <div class="paginate" >
            <div class="divButton">
                <my-button @click="this.goToPage($event, this.engine.paginate.buttonGoStart.id)"
                           :ref=this.engine.paginate.buttonGoStart.ref
                           :heightButton=22
                           :buttonType=2
                           :title='"goto first pagina"'>
                    <font-awesome-icon :icon=this.cfgIconPictureAction(this.engine.paginate.buttonGoStart.icon) size="1x"/>
                </my-button>
            </div>
            <div class="divButton">
                <my-button @click="this.goToPage($event, this.engine.paginate.buttonGoLeft.id)"
                           :ref=this.engine.paginate.buttonGoLeft.ref
                           :heightButton=22
                           :buttonType=2
                           :title='"previous page"'>
                    <font-awesome-icon :icon=this.cfgIconPictureAction(this.engine.paginate.buttonGoLeft.icon) size="1x"/>
                </my-button>
            </div>

            <template  v-for="(pgn, index) in this.paginate.pag.buttons.bt" :key='index'>
                <div class="divButtonDinamic" v-if="!pgn.isDisable">
                    <my-button v-bind:class="{'ff-button-selected': pgn.selected}" @click="this.goToPage($event, pgn.caption)" :widthButton=35 :heightButton=22 :buttonType=2 :title='this.privateGetPageTitle(pgn.caption)'>
                        {{pgn.caption}}
                    </my-button>
                </div>
                <div class="divButtonDinamic" v-if="pgn.isDisable">
                    <div class="divSapacer" :style="{widht:'35px'}"></div>
                </div>
            </template>

            <div class="divButton">
                <my-button @click="this.goToPage($event, this.engine.paginate.buttonGoRight.id)"
                           :ref=this.engine.paginate.buttonGoRight.ref
                           :heightButton=22
                           :buttonType=2
                           :title='"next page"'>
                    <font-awesome-icon :icon=this.cfgIconPictureAction(this.engine.paginate.buttonGoRight.icon) size="1x"/>
                </my-button>
            </div>
            <div class="divButton">
                <my-button @click="this.goToPage($event, this.engine.paginate.buttonGoEnd.id)"
                           :ref=this.engine.paginate.buttonGoEnd.ref
                           :heightButton=22
                           :buttonType=2
                           :title='"goto last page"'>
                    <font-awesome-icon :icon=this.cfgIconPictureAction(this.engine.paginate.buttonGoEnd.icon) size="1x"/>
                </my-button>
            </div>
            <div class="divButtonGoTo">
                <my-button @click="this.jumpPage($event)"
                           :heightButton=22
                           :buttonType=2
                           :title='"goto number page"'>
                    Goto page
                </my-button>
            </div>
            <div class="divInputGoto">
                <page-nr-field :ref=this.REF_INPUT_PAGE_NR
                               :size=1
                               :pPlaceHolder="'nr. page'" v-on:keyup="privateEnterGotoPage">

                </page-nr-field>
            </div>

            <div class="divLabelInfo" :title="this.privatePaginateTitleRecords()">
                <label>{{this.paginate.pag.page}}/{{this.paginate.pag.total_pages}}</label>
            </div>

        </div>

    </div>
</template>

<script>

	import Button from '@/components/base/Button.vue';
	import InputField from "@/components/base/InputField.vue";
    import MyInputField from "./InputField";


	export default {
		name: "grid-ul",
		components: {
            MyInputField,
			'my-button': Button,
            'page-nr-field': InputField,
            'text-filter': InputField
		},
        props: {
            pConfig: {type: Object, required: true}
        },
		created() {
			this.REF_DIV_CONTAINER = 'refDivContainer',
            this.REF_DIV_TABLE  = 'refDivTable',
            this.REF_TABLE      = 'refTable',
			this.REF_THEAD      = 'refThead',
            this.REF_TABLE_BODY = 'refBody',
	        this.REF_INPUT_PAGE_NR = 'refPageNumber',
            this.REF_TOOLBAR = 'refToolbar',
            this.KEY_PRESS_CONTROL_BROWSER = ['Tab', 'Escape'],
            this.engine = {
                tabIndexValue: 0,
                tdCurent: null,
                trCurent: null,
                maximRows: 0,
	            CLASS_SELECTED: 'selected',
                CLASS_DINAMIC_BUTTON_PAG: 'divButtonDinamic',
	            CLASS_PERMANENT_OVER: 'ff-button-selected',
	            timeOut: null,                       // delay preskey filter
	            TIME_OUT_DELAY_FOR_FILTER: 600,
                FILTER_MIN_CHARACTER: 2,
                paginate: {
                    buttonGoStart:{
                        id: 'b1',
                        icon: {fawIcon:'fas', icon: 'angle-double-left', color: "darkred"},
                        ref: 'refGoStart'
                    },
                    buttonGoLeft: {
                        id: 'b2',
                        icon: {fawIcon:'fas', icon: 'angle-left', color: "darkred"},
	                    ref: 'refGoLeft'
                    },
                    buttonGoRight: {
                        id: 'b3',
                        icon: {fawIcon:'fas', icon: 'angle-right', color: "darkred"},
	                    ref: 'refGoRight'
                    },
                    buttonGoEnd:{
                        id: 'b4',
                        icon: {fawIcon:'fas', icon: 'angle-double-right', color: "darkred"},
	                    ref: 'refGoEnd'
                    },
                    maxButtonPage: 5
                }
            },
            this.paginate.pag.buttons.bt = this.$vanilla.generateButton(this.pConfig.paginate.nrButtonShow);

        },
        beforeMount(){
            // set header for order by
            let first = true; // only one column have order by, first when have many settings

            for (let i = 0; i<this.pConfig.header.length; i++ ){

            	// for order by
                if(this.pConfig.header[i].orderBy.order){
                    let orderDefaultIcon = null;
                    if(this.pConfig.header[i].orderBy.defaultOrder && first){
                        orderDefaultIcon = this.$constGrid.ORDER_ASC;
                        first = false;
                    }
                    this.orderBy.header.push(this.$constGrid.getOrderByReactive(this.pConfig.header[i].id, orderDefaultIcon, this.pConfig.header[i].tableFieldName));

                    if(this.pConfig.header[i].orderBy.defaultOrder) {
	                    this.setOrderBy(this.pConfig.header[i].tableFieldName, orderDefaultIcon);
                    }

                }
	            // for filter by
	            if(this.pConfig.header[i].filterBy){
                	// type inca nu este folosit
                	this.filterBy.header.push(this.$constGrid.getFilterByReactive(this.pConfig.header[i].id, this.pConfig.header[i].fieldFilterName, null, false, null, this.cfgIconColor('white')));

                }
            }
        },
		mounted() {
			this.cfgGrid();
			this.goToPage( null, '1');
			// this.getDataFromServer('mounted');

            // set dimension for parent div
			let divParent = this.$refs[this.REF_DIV_CONTAINER].parentNode;
			let bounding = divParent.getBoundingClientRect();
			divParent.style.maxWidth = bounding.width + 'px';
			divParent.style.maxHeight = bounding.height + 'px';

		},
        computed: {
        },
        methods: {
	        getDataFromServer: function (fromID) {

	            if(this.$check.isUndef(this.pConfig.cfg.urlData)){
                    this.showModalLoadingDiv = false;
	                return;
                }
		            this.showModalLoadingDiv = true;

	        	    // fromId for debug only
	        	    // console.log('getDataFromServer: ' + fromID);

			        let uri = this.$url.getUrl(this.pConfig.cfg.urlData);
			           this.axios
					        .post(uri, this.post)
					        .then(response => {
						        this.showModalLoadingDiv = true;
						        this.paginate.totalRecords = response.data.paginate.records;
						        this.rezultData = response.data.records;
					        })
                            .catch(error => console.log(error))
                            .finally(() => {

						        this.privateSetPaginatePag(1);
						        this.$nextTick(function () {
							        this.initGrid();
						        });

                                this.privateSetPaginatePag(1);
                                this.privateLoadAndDrawGrid();
                                this.showModalLoadingDiv = false;
				            });

		    },
            checkFieldHeader: function(fieldName){
	            // console.log(field);
                ///console.log(this.pConfig.header);
                let find = this.$vanilla.getAtributeValueFromArrayObject(this.pConfig.header,'tableFieldName', fieldName, 'tableFieldName');

                if(this.$check.isUndef(find)){
                    return false;
                }

	            return true;
            },
            refreshGrid: function (recordType, externalFiltering) {
	        	let jumpNrPage = '1';

	        	if(!this.$check.isUndef(recordType)){
	        		if(recordType == this.$constGrid.SQL_UPDATE){
				        jumpNrPage = this.paginate.pag.page.toString();
                    }
                }
	            this.goToPage(null, jumpNrPage);
            },
            getDataSelected: function () {
		        return this.selectdRow;
	        },
            initGrid: function () {
		        this.engine.maximRows = this.paginate.pag.data.length;
		        if (this.engine.maximRows > 0) {
			        this.privateSelectedRow(this.$refs[this.REF_TABLE_BODY].rows[0]);
		        }

	        },
            setFocusTD: function () {
		        this.engine.tdCurent.focus();

	        },
            resetSelectionRow: function(){
	        	this.selectdRow = {};
	        	this.showSelectedData = '...';
	        	this.enabledToolBar(false);
	            this.privateRemoveSelectedRow();

            },
            enabledToolBar: function (enabled){
                if(this.pConfig.toolbar.show) {
                    let buttons = this.$refs[this.REF_TOOLBAR].getElementsByTagName('button');

                    for (let i = 0; i < buttons.length; i++) {

                        if (enabled) {
                            this.$vanilla.enabledButton(buttons[i]);
                        }
                        else {
                            this.$vanilla.disableButton(buttons[i]);
                        }

                    }
                }

            },
            setOrderBy: function (fieldName, order){
	              this.post.orderBy.fieldName = fieldName;
                  this.post.orderBy.order = order;

            },
            privatePaginateTitleRecords: function () {

	        	return 'total records: ' + this.paginate.pag.total;
            },
            privateGetHeaderColumn: function (obj){

	            let headerReturn = null;
	            let idHeader = null;

	            if (isNaN(obj)) {
	                // este orice obiect din interiorul th
		            if (obj.target)
		            {
                        // is event
			            headerReturn = obj.target.closest("th");
                    }else{
			            headerReturn = obj.closest("th");
                    }

		            idHeader = headerReturn.getAttribute('id');

	            } else {
                    // este numar, reprezinta id header

		            idHeader = obj;

		            let headers = this.$refs[this.REF_THEAD].getElementsByTagName('th');

		            for(let i=0; i < headers.length; i++ ){
			            if(headers[i].getAttribute('id') == idHeader){
				            headerReturn =  headers[i];
				            break;
			            }
		            }
	            }

	            let filterByInput = headerReturn.getElementsByTagName('input')[0];

                return {header: headerReturn, idHeader: idHeader, filterByInput: filterByInput};
            },

	        privateReactiveShowFilterDiv: function (idHeader) {

	        	let returnValue = false;

	        	for(let i=0; i < this.filterBy.header.length ;i++){
	        	    if(this.filterBy.header[i].id == idHeader){
			            returnValue = this.filterBy.header[i].showInputDiv ;
			            break ;
                    }
                }
	        	return returnValue;
	        },
            privateShowMarkFilter: function (id) {
	        	let colorReturn = this.cfgIconColor('white');

	            for(let i=0; i < this.filterBy.header.length ;i++){
		            if( !this.$check.isUndef(this.filterBy.header[i].filterString) && this.filterBy.header[i].id == id && this.filterBy.header[i].filterString.length > 0 ){

			            colorReturn = this.cfgIconColor('brown');
			            this.filterBy.header[i].iconColor = colorReturn;
			            break;
                    }
                }

	            return colorReturn;
            },
	        privateClearFilter: function(event){

		        let headerReturn = this.privateGetHeaderColumn(event);
		        headerReturn.filterByInput.value = '';

		        this.privateSetFilterValue(headerReturn.idHeader ,'');


            },
            privateShowFilterDiv: function (event) {

	        	if(this.showModalLoadingDiv){
	        		return;
                }

	            let header = this.privateGetHeaderColumn(event);

	            for(let i=0; i < this.filterBy.header.length ;i++){

		            if(this.filterBy.header[i].id == header.idHeader){
			            if(this.filterBy.header[i].showInputDiv){
				            this.filterBy.header[i].showInputDiv = false;
                        }else{
				            this.filterBy.header[i].showInputDiv = true;
				            this.$nextTick(() => {header.filterByInput.focus(); header.filterByInput.select();});
                        }
		            }else{
			            this.filterBy.header[i].showInputDiv = false;
                    }
	            }

            },
	        privateKeyPresFilter: function (event) {
		        if(this.KEY_PRESS_CONTROL_BROWSER.includes(event.key)) {
			        // do nothing
		        } else {
			        this.privateDelayFilterReset();
			        let wordFilter = event.target.value;

			        if(wordFilter.length >= this.engine.FILTER_MIN_CHARACTER || wordFilter.length < this.engine.FILTER_MIN_CHARACTER) {
				        this.privateDelayFilter(event.target);

			        }
		        }
	        },
            privateSetFilterValue: function (idHeader, newValue, reset) {
	        	for(let i=0; i< this.filterBy.header.length; i++){
	        		if(this.filterBy.header[i].id == idHeader){

	        			if(this.filterBy.header[i].filterString != newValue){
					        this.filterBy.newFilter = true;

					        if(newValue.length < this.engine.FILTER_MIN_CHARACTER){
						        newValue = null;
                            }

					        this.filterBy.header[i].filterString = newValue;
                        }
                    }
                }

                if(this.filterBy.newFilter){
	                this.post.filterBy = this.filterBy;

	        		// send request to server
	                this.goToPage(null, "1");
                }
            },
            privateFilterBy: function (target){
	        	let header = this.privateGetHeaderColumn(target);
	            this.privateSetFilterValue(header.idHeader, header.filterByInput.value);

            },
	        privateDelayFilter: function(target){
		        this.engine.timeOut = setTimeout( () => this.privateFilterBy(target), this.engine.TIME_OUT_DELAY_FOR_FILTER);
	        },
	        privateDelayFilterReset: function(){
		        if(this.engine.timeOut != null){
			        clearTimeout(this.engine.timeOut);
		        }
	        },
	        privateOrderBy: function (event) {

		        if(this.showModalLoadingDiv){
			        return;
		        }

                let idHeader = event.target.closest("div").firstChild.getAttribute('idheader');

                let orderBy = this.$vanilla.getAtributeValueFromArrayObject(this.orderBy.header, 'id', idHeader);
                let order = null;
                let fieldName = null;

                if(this.$check.isUndef(orderBy.order)){
                    order = this.$constGrid.ORDER_ASC;
                } else {
                    order = this.$constGrid.ORDER_ASC;
                    if(orderBy.order == this.$constGrid.ORDER_ASC){
                        order = this.$constGrid.ORDER_DESC;
                    }
                }

                for (let i = 0; i < this.orderBy.header.length; i++){
                    this.orderBy.header[i].order = null;
                    if(this.orderBy.header[i].id == idHeader){
                        this.orderBy.header[i].order = order;
                        fieldName = this.orderBy.header[i].fieldName;
                    }
                }

                // for post data
                this.setOrderBy(fieldName, order);

                // send filter
		        this.goToPage(null, this.post.paginate.pageNumber.toString());

            },
            privateIconOrderBy: function (idHeader){

                let order = this.$vanilla.getAtributeValueFromArrayObject(this.orderBy.header, 'id', idHeader);
	            let returnVal = 0;

	            if(order.order == this.$constGrid.ORDER_ASC){
                    returnVal = 1;
                }else if(order.order == this.$constGrid.ORDER_DESC){
                    returnVal = 2;
                }
	            return returnVal;
            },
            privateLoadAndDrawGrid: function(){
	            this.privatedPageToolDraw(this.post.paginate.pageNumber);
	            this.privateSetPaginatePag(this.post.paginate.pageNumber);
	            this.privateCfgPaginateArrowButton();

            },
	        privateEnterGotoPage: function (event){
	            if(event.key == 'Enter'){
	            	this.jumpPage();
                }
            },
            privatedPageToolDraw: function (pageNumber){
		        let buttonArrayLenght = this.paginate.pag.buttons.bt.length;
		        let firstPageButton = parseInt(this.paginate.pag.buttons.bt[0].caption);
		        let lastPageButton = parseInt(this.paginate.pag.buttons.bt[buttonArrayLenght - 1].caption);

		        let newPageNumber = pageNumber;
		        let changeLabel = false;
		        if(pageNumber>lastPageButton || pageNumber<firstPageButton){
			        changeLabel = true;
		        }

		        for(let i=0; i < buttonArrayLenght; i++ ) {

	        	    if(changeLabel){
			            this.paginate.pag.buttons.bt[i].caption = newPageNumber.toString();
			            newPageNumber++;
                    }

			        let isSelected = false;
			        if(this.paginate.pag.buttons.bt[i].caption == pageNumber.toString()) {
				        isSelected = true;
			        }
			        this.paginate.pag.buttons.bt[i].selected = isSelected;

			        let isDisabled = false;
			        if(parseInt(this.paginate.pag.buttons.bt[i].caption) > this.paginate.pag.total_pages){
				        isDisabled = true;
			        }

			        this.paginate.pag.buttons.bt[i].isDisable = isDisabled;
                }



            },

	        jumpPage: function () {
                let input = this.$refs[this.REF_INPUT_PAGE_NR];
                let pageNumber = parseInt(input.getValue());

                if(input.getValue()>=1 && pageNumber<=this.paginate.pag.total_pages){
                	this.goToPage(null, pageNumber.toString());
                }

	        },
            goToPage: function (event, buttonNumber) {

		        let pageNumber = null;
		        if (buttonNumber.slice(0, 1) == 'b') {

			        if (buttonNumber == this.engine.paginate.buttonGoStart.id) {
				        pageNumber = 1;

			        }
			        else if (buttonNumber == this.engine.paginate.buttonGoLeft.id) {
				        pageNumber = this.paginate.pag.pre_page;

			        }
			        else if (buttonNumber == this.engine.paginate.buttonGoRight.id) {
				        pageNumber = this.paginate.pag.next_page;
			        }
			        else if (buttonNumber == this.engine.paginate.buttonGoEnd.id) {
				        pageNumber = this.paginate.pag.total_pages;
			        }

		        }
		        else {
			        pageNumber = parseInt(buttonNumber);

		        }

			        this.post.paginate.pageNumber = pageNumber;
			        this.post.paginate.perPage = this.pConfig.paginate.recordsPerPage;

				    this.getDataFromServer('goToPage');
	                this.resetSelectionRow();
	        },
            privateSetPaginatePag: function (pageNumber){
	            let paginate = this.$vanilla.paginateArray(this.rezultData, pageNumber, this.pConfig.paginate.recordsPerPage, false, this.paginate.totalRecords);

                this.paginate.pag.data        = paginate.data;
                this.paginate.pag.next_page   = paginate.next_page;
                this.paginate.pag.page        = paginate.page;
                this.paginate.pag.pre_page    = paginate.pre_page;
                this.paginate.pag.total       = paginate.total;
                this.paginate.pag.total_pages = paginate.total_pages;

            },
            privateCfgPaginateArrowButton:function(){
	        	let disableLeft = false;
	            let disableRight = false;

	        	if(this.paginate.pag.page == 1){
			        disableLeft = true;
                }

                if(this.paginate.pag.page == this.paginate.pag.total_pages || this.paginate.pag.total_pages == 0){
	                disableRight = true;
                }

	            this.$refs[this.engine.paginate.buttonGoStart.ref].disable(disableLeft);
	            this.$refs[this.engine.paginate.buttonGoLeft.ref].disable(disableLeft);

	            this.$refs[this.engine.paginate.buttonGoEnd.ref].disable(disableRight);
	            this.$refs[this.engine.paginate.buttonGoRight.ref].disable(disableRight);

            },
            privateGetPageTitle: function (page){
	            return 'goto page ' + page;

            },
	        privateRemoveSelectedRow: function(){
		        if(  !this.$check.isUndef(this.engine.trCurent)){
			        this.engine.trCurent.removeAttribute('class', this.engine.CLASS_SELECTED);
		        }
            },
            privateSelectedRow: function (tr) {

                if(  !this.$check.isUndef(this.engine.trCurent)){
                    this.engine.trCurent.removeAttribute('class', this.engine.CLASS_SELECTED);
                }

                this.engine.trCurent = tr;
                if(this.$check.isUndef(this.engine.tdCurent)){
                    this.engine.tdCurent = this.engine.trCurent.cells[0];
                }else{
                    this.engine.tdCurent = this.engine.trCurent.cells[this.engine.tdCurent.cellIndex];
                }

                this.engine.trCurent.setAttribute('class', this.engine.CLASS_SELECTED);

                this.privateGetDataFromTr();

                // this.setFocusTD();
            },
            privateGetDataFromTr: function (){

                let finalSelected = {};
                finalSelected[this.$constGrid.ID_NAME] = this.engine.trCurent.getAttribute(this.$constGrid.ID_NAME);

                let cells = this.engine.trCurent.cells;

                for (const c of cells) {
                   let fieldName = c.firstChild.getAttribute(this.$constGrid.BODY.FIELD_NAME);
                   if(this.pConfig.returnField.includes(fieldName)){
                        finalSelected[fieldName] = c.innerText;
                    }
                }

                this.selectdRow = finalSelected;

                this.enabledToolBar(true);

                this.privateMakeShowDataSelected();

            },
            privateMakeShowDataSelected: function (){
	            if(this.pConfig.toolbar.show) {

	            	let text = '';

		            for (const cfield of this.pConfig.toolbar.fieldShow.field) {
		            	text += this.selectdRow[cfield] + this.pConfig.toolbar.fieldShow.separator;
                    }

                    if(this.pConfig.toolbar.fieldShow.includeIdPk){
	                    text = '('+ this.selectdRow[this.$constGrid.ID_NAME] +') ' + text;
                    }

		            this.showSelectedData =  text;
	            }

            },
            privateSelectedCell: function (td) {
                this.engine.tdCurent = td;
                this.setFocusTD();

            },
            privateArrowDown: function () {
                if(this.engine.trCurent.sectionRowIndex < (this.paginate.pag.data.length - 1)) {
                    this.privateSelectedRow(this.engine.trCurent.nextSibling);
                }

            },
            privateArrowUp: function () {
                if(this.engine.trCurent.sectionRowIndex > 0) {
                    this.privateSelectedRow(this.engine.trCurent.previousSibling);
                }

            },
            privateArrowRight: function () {
                if(!this.$check.isUndef(this.engine.tdCurent.nextElementSibling) ){
                    this.privateSelectedCell(this.engine.tdCurent.nextElementSibling);
                }

            },
            privateArrowLeft: function () {
                if(!this.$check.isUndef(this.engine.tdCurent.previousElementSibling) ){
                    this.privateSelectedCell(this.engine.tdCurent.previousElementSibling);
                }

            },
		    emitAction:function(event, action) {
                this.cfgMouseNavigate(event);
                this.$emit(action, this.selectdRow);

            },
	        emitActionToolbar: function (event, action) {
            	if(this.pConfig.toolbar.show) {
		            this.$emit(action, this.getDataSelected());
	            }

	        },
            cfgGrid: function () {
                let divTable = this.$refs[this.REF_DIV_TABLE];
                let headerCells = this.$refs[this.REF_THEAD].rows[0].cells;

                this.cfgGridHeader(headerCells);

                let widthPixel = this.pConfig.cfg.width;
                if(parseInt(widthPixel) != NaN){
	                widthPixel = widthPixel  + 'px';
                }

                divTable.style.width = widthPixel;
                divTable.style.height = this.pConfig.cfg.height  + 'px';

            },
            cfgKeyNavigate: function (event){
                if (event.key == 'ArrowRight') {
                    this.privateArrowRight();
                }else if(event.key == 'ArrowLeft'){
                    this.privateArrowLeft();
                }else if(event.key == 'ArrowDown'){
                    this.privateArrowDown();
                }else if(event.key == 'ArrowUp'){
                    this.privateArrowUp();
                }else if(event.key == 'Enter'){
                    //this.selectData();
                    //this.$emit(this.engine.emit.selectData);
                }else if(event.key == 'Tab'){
                    //this.$emit(this.engine.emit.tabKey);
                }
            },
            cfgMouseNavigate(event){
                this.engine.tdCurent = event.target.closest('td');
                this.privateSelectedRow(event.target.closest('tr'));
            },
            cfgIconPictureAction: function (icon) {
                return [icon.fawIcon, icon.icon];
            },
            cfgIconColor: function (color) {
                return {
                    color: color
                }
            },
            cfgGridHeader: function (headerCells) {
                for (let i = 0; i < headerCells.length; i++) {
                    let width = this.$vanilla.getAtributeValueFromArrayObject(this.pConfig.header,'id',headerCells[i].getAttribute('id'),'width');
                    headerCells[i].style.width = width + 'px';
                }
            },
            cfgGetTabIndex: function(){
              this.engine.tabIndexValue++;
              return this.engine.tabIndexValue;
            },
            cgfTDStyle: function (fieldName) {
	            let width = this.$vanilla.getAtributeValueFromArrayObject(this.pConfig.header,this.$constGrid.HEADER.TABLE_FIELD_NAME,fieldName,'width');
	            return {
	            	width: width + 'px'
                }
            }
        },
		data () {
			return {
				showModalLoadingDiv: true,
				rezultData: new Array(),
                selectdRow: {},
                showSelectedData: '...',
                paginate: {
					totalRecords: 0,
				    buttonPageNumber: ['22','23','34','45','56','68'],
                    pag: this.$vanilla.paginateArray(new Array())
                },
                orderBy: {
                    header: new Array()
                },
                filterBy: {
				    header: new Array(),
                    newFilter: false
                },
				post: {
					    paginate:{ 'perPage': this.pConfig.paginate.recordsPerPage , 'pageNumber': 1, 'countRecords': -1  },
                        orderBy: {fieldName: null, order: null},
                        filterBy: {
					        header: new Array(),
                            newFilter: false
                        }
				}
            }
		}
	}
</script>

<style scoped>
</style>
