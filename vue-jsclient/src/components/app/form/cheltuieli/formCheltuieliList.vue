<template>
    <validate-window ref="validateWindowRef"
                     :cWidth=500
                     :cHeight=200
                     :cTypeWindows=1
    ></validate-window>

    <validate-window ref="infoWindowRef"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=5
    ></validate-window>

    <validate-window ref="redWindowRef"
                     :cWidth=400
                     :cHeight=200
                     :cTypeWindows=6
    ></validate-window>

    <validate-window ref="refYesNo"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoButton"
    ></validate-window>

    <form-tab :ref = this.REF_FORM>
        <template v-slot:slotTitle></template>
        <template v-slot:slotContent>
            <table class="ff-form-table">
                <tr>
                    <td class="label-left bold" colspan="1">
                        <label :for=this.cfgtime.DATA_IN.id>{{this.cfgtime.DATA_IN.caption}}</label>
                        &nbsp;
                        <my-datetime
                            :ref = this.cfgtime.DATA_IN.ref
                            :pConfig = this.cfgtime.DATA_IN
                        ></my-datetime>
                        -
                        <my-datetime
                            :ref = this.cfgtime.DATA_SF.ref
                            :pConfig = this.cfgtime.DATA_SF
                        ></my-datetime>
                    </td>

                    <td class="control">
                        <my-dropdown-search :ref = this.cfgtime.PARTNER_LIST.ref
                                            :pConfig = this.cfgtime.PARTNER_LIST
                        ></my-dropdown-search>
                    </td>

                    <td class="control">
                        <div class="prime-button last-button">
                            &nbsp;
                            <my-button  :ref=this.cfgtime.REF_BUTTON_REFRESH @click="this.clickExpenseList" :heightButton=22 :buttonType=2 title="refresh lista" :style="this.cfgtime.ICON_REFRESH.colorStyle">
                                <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.cfgtime.ICON_REFRESH) size="1x" />
                            </my-button>
                        </div>
                    </td>
                </tr>
            </table>

            <br>

            <div class="form-rezumat-left">
                <table class="ff-form-table">
                    <tr>
                        <td><div style="width: 20px"></div></td>
                        <td class="label-left bold">
                            <label>Inregistrari:</label></td>
                        <td class="control">
                            {{this.dataRezume.nr_records}}
                        </td>
                        <td class="label-left bold">
                            <label>&nbsp;&nbsp;&nbsp;TVA:</label></td>
                        <td class="control">
                            {{this.dataRezume.total_expense_tva}}
                        </td>
                        <td class="label-left bold">
                            <label>&nbsp;&nbsp;&nbsp;Total:</label></td>
                        <td class="control">
                            {{this.dataRezume.total_expense}}
                        </td>
                    </tr>
                </table>
            </div>

            <my-list
                :ref = this.cfgtime.CFG_EXPENSE_LIST.ref
                :pConfig = this.cfgtime.CFG_EXPENSE_LIST
                @emitFinallyCustomResponse="emitListResumData"
                @emitDeleteExpense = "emitDeleteExpense"
                @emitShowDetail = "emitShowDetail"
            ></my-list>


            <my-popup
                    :ref = this.cfgtime.CFG_POPUP_DETAIL.ref
                    :pConfig = this.cfgtime.CFG_POPUP_DETAIL
            >
                <template v-slot:slotContent>
                    <my-list-detail
                            :ref = this.cfgtime.CFG_EXPENSE_DETAIL_LIST.ref
                            :pConfig = this.cfgtime.CFG_EXPENSE_DETAIL_LIST
                    ></my-list-detail>
                </template>
            </my-popup>

        </template>
        <template v-slot:slotButton>
        </template>
    </form-tab>
</template>

<script>
    import AlertWindow    from "@/components/base/AlertWindow.vue";
    import FormTab        from "@/components/base/FormTab.vue";
    import Lista          from "@/components/base/Lista";
    import InputDateTime  from "@/components/base/InputDateTime.vue";
    import Button         from "@/components/base/Button";
    import DropDownSearch from "@/components/base/DropDownSearch.vue";
    import PopUpWindow    from "@/components/base/PopUpWindow";


    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
            'my-list': Lista,
            'my-datetime': InputDateTime,
            'my-dropdown-search': DropDownSearch,
            'my-button': Button,
	        'my-popup': PopUpWindow,
	        'my-list-detail': Lista
        },
        name: "form-partener",
        created() {
            this.REF_FORM = 'refFormModel';
            this.cfgtime = {
                REF_BUTTON_REFRESH: 'refButtonRefresh',
                ICON_REFRESH: this.$constComponent.ICON_REFRESH("green"),
                PARTNER_LIST: this.cfgDropDownPartner(),
                DATA_IN: this.cfgDataIn(),
                DATA_SF: this.cfgDataSf(),
                URL_DELETE_SAVE_EXPENSE: this.$url.getUrl('deleteSaveExpense'),
                CFG_POPUP_DETAIL : {
	                ref: 'refPopUpDetail',
                    title: 'Lista cheltuieli',
                    height: null,
                    width: null,
	                urlData: 'hahaha'
                },
                CFG_EXPENSE_LIST : {
                    ref: 'refDetailList',
                    header: [
                        this.$constList.getHeader(1, 'Data',             90, 'data_c',          this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER ),
                        this.$constList.getHeader(2, 'Nr. doc.',        100, 'nr_doc',          this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER  ),
                        this.$constList.getHeader(3, 'Tip plata',       100, 'tip_plata',       this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER ),
                        this.$constList.getHeader(4, 'Tip doc.',        140, 'tipd',            this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER  ),
                        this.$constList.getHeader(5, 'Tip cheltuiala.', 140, 'tipc',            this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER  ),
                        this.$constList.getHeader(6, 'Furnizor',        450, 'nume_furnizor',   this.$constList.HEADER.CAPTION_TYPE_FIELD),
                        this.$constList.getHeader(7, 'TVA',             90, 'total_tva',        this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT),
                        this.$constList.getHeader(8, 'Total',           90, 'total',            this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER),
                        this.$constList.getHeader(10, 'Action',         100, 'null',            this.$constList.HEADER.CAPTION_TYPE_ACTION)
                    ],
                    recordActionButon: [
	                    this.$constList.getActionButton(21, 'detalii cheltuieli', 'emitShowDetail', this.$constGrid.ICON_POPUP, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null),
                        this.$constList.getActionButton(20, 'sterg cheltuiala', 'emitDeleteExpense', this.$constGrid.ICON_DELETE, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null)
                        // this.$constList.getActionButton(5, 'adresa implicita', 'emitAdresaImplicita', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('ro', false)),   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0

                    ],
                    cfg: {  urlData: 'expenseList', loadOnCreate: false,
                        filedNameForCheckBox: 'activ',
                        headerLenghtActivate: true,                         // tine cont de lungimea coloanelor setate in header
                        emitListRowSelection: 'emitListRowSelection',
                        heightList: 700
                    }
                },
	            CFG_EXPENSE_DETAIL_LIST : {
		            ref: 'refExpenseDetailList',
		            header: [
			            this.$constList.getHeader(1, 'Nr.'              ,20     ,'row_num'          , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER  ),
			            this.$constList.getHeader(2, 'Cat'              ,100    ,'tip_cat'          , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER ),
			            this.$constList.getHeader(3, 'Nume produs'      ,400    ,'produs'           , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_LEFT  ),
			            this.$constList.getHeader(4, 'UM'               ,30     ,'um'               , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER  ),
			            this.$constList.getHeader(5, 'Cantitate'        ,80     ,'cantitate'        , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER  ),
			            this.$constList.getHeader(6, 'Pret unitar'      ,100    ,'pret_unitar'      , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT  ),
			            this.$constList.getHeader(7, 'Valoare fara TVA' ,110    ,'total_fara_tva'   , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT  ),
			            this.$constList.getHeader(8, 'Valoare TVA'      ,100    ,'total_tva'        , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT  ),
			            this.$constList.getHeader(9, 'Total'            ,90     ,'total'            , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT  ),
			            this.$constList.getHeader(10, '% TVA'           ,70     ,'procent_tva'      , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT  )

			            // this.$constList.getHeader(20, 'Action'       ,100    ,'null', this.$constList.HEADER.CAPTION_TYPE_ACTION)
		            ],
		            recordActionButon: [
			            // this.$constList.getActionButton(4, 'sterg articol', 'emitStergArticol', this.$constGrid.ICON_DELETE, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null)
			            // this.$constList.getActionButton(5, 'adresa implicita', 'emitAdresaImplicita', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('ro', false)),   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
			            // this.$constList.getActionButton(6, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00'))
		            ],
		            cfg: { urlData: 'detailExpenseList', loadOnCreate: false,
			            filedNameForCheckBox: 'activ',
			            headerLenghtActivate: true,                         // tine cont de lungimea coloanelor setate in header
			            emitListRowSelection: 'emitListRowSelection'},
		                heightList: 500
	            }
            },
            this.runtime = {
                sendDataToServer: false,
                yesNoMethod: 'methodName',
                post: { idPk: null, field: {}, sqlAction: null},
                paramExpenseList: {'dataIn': null, 'dataSf': null, idPartner: 0}

            }
        },
        emits: ['emitModel'],
        mounted () {
        },
        methods: {
            refreshExpenseList: function(){
                this.privateParameterExpense();
                this.$refs[this.cfgtime.CFG_EXPENSE_LIST.ref].showList(this.runtime.paramExpenseList);
            },
            clickExpenseList: function() {
                this.refreshExpenseList();
            },
            serverDeleteExpense: function (){
                if(!this.runtime.sendDataToServer) {
                    this.runtime.yesNoMethod = 'serverDeleteExpense';
                    this.$refs.refYesNo.setCaption("Sterg");
                    this.$refs.refYesNo.setMessage("Sterg cheltuiala ? <br> Datele sterse nu mai pot fi recuperate.");
                    this.$refs.refYesNo.show();
                }

                if(this.runtime.sendDataToServer) {
                    this.runtime.sendDataToServer = false;

                    this.$refs[this.REF_FORM].showModal(true);
                    this.axios
                        .post(this.cfgtime.URL_DELETE_SAVE_EXPENSE, this.runtime.post)
                        .then(response => {
                            if (response.data.succes){
                            }
                            else {
                                this.$refs.validateWindowRef.setCaption("Fail...");
                                this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
                                this.$refs.validateWindowRef.show();
                            }

                        })
                        .catch(error => console.log(error))
                        .finally(() => {
                            this.refreshExpenseList();
                            this.$refs[this.REF_FORM].showModal(false);
                        });
                }

            },
	        emitShowDetail: function (button) {
		        let tr = button.closest('tr');
		        let id = tr.getAttribute('idPk');

		        let listDetail = this.$refs[this.cfgtime.CFG_EXPENSE_DETAIL_LIST.ref];
			    listDetail.showList({idExpense: id});
		        let popUp     = this.$refs[this.cfgtime.CFG_POPUP_DETAIL.ref];
		        popUp.setCaption('Detalii pentru: ' + id + ' ');
		        popUp.show();

	        },
            emitDeleteExpense: function (button) {
                let tr = button.closest('tr');
                this.runtime.post.idPk = tr.getAttribute('idPk');
                this.serverDeleteExpense();
            },
            emitListResumData: function (resume){
                this.dataRezume.nr_records        = resume.nr_records;
                this.dataRezume.total_expense     = resume.total_expense;
                this.dataRezume.total_expense_tva = resume.total_expense_tva;

            },
            privateParameterExpense: function (){
                this.runtime.paramExpenseList.dataIn = this.$refs[this.cfgtime.DATA_IN.ref].getValue();
                this.runtime.paramExpenseList.dataSf = this.$refs[this.cfgtime.DATA_SF.ref].getValue()

                let partnerParam = this.$refs[this.cfgtime.PARTNER_LIST.ref].getValue();
                if(this.$check.isUndef(partnerParam)){
                    this.runtime.paramExpenseList.idPartner = 0;
                }else{
                    this.runtime.paramExpenseList.idPartner = partnerParam.id;
                }
            },
            emitYesNoButton: function (yes) {
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
                    this[this.runtime.yesNoMethod].apply();
                }else{
                    this.runtime.sendDataToServer = false;
                }
            },
            setPost: function (component, value){
                this.runtime.post['field'][component.name] = value;
            },
            cfgDropDownPartner: function(){
                let cfg = this.$app.cfgSelectSearch('nomPartner', this.$url.getUrl('listPartener'), 450);
                cfg.setValidateFunction(this.validatePartner);
                cfg.setCaption("Partener");
                cfg.setMandatory(true);
                return cfg;
            },
            cfgDataIn: function(){
                let cfg = this.$app.cfgInputDateTimeField("invoiceDateIn", 11, 80);
                cfg.setValidateFunction(this.validateDocumentDate);
                cfg.setCaption("Interval");
                cfg.setMandatory(true);
                cfg.setShowDefault(this.$constBussines.DATE_FIRSTDAY);
                return cfg;
            },
            cfgDataSf: function(){
                let cfg = this.$app.cfgInputDateTimeField("invoiceDateSf", 11, 80);
                cfg.setValidateFunction(this.validateDocumentDate);
                cfg.setCaption("Interval");
                cfg.setMandatory(true);
                cfg.setShowDefault(this.$constBussines.DATE_CURRENT);
                return cfg;
            }
        },
        data () {
            return {
                dataRezume: {nr_records: 0, total_expense: 0, total_expense_tva: 0}
            }
        }
    }

</script>

<style scoped></style>
