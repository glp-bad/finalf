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
        <template v-slot:slotTitle>
        </template>
        <template v-slot:slotContent>
            <!-- antet cheltuiei ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

            <div class="ff-flex-form-center-align">
                <div class="item-column">
                    <div class="control">
                        <my-radio-button
                            :ref = this.cfgtime.TIP_PLATA.ref
                            :pConfig = this.cfgtime.TIP_PLATA
                            @emitClickTipPlata = 'emitClickTipPlata'
                        ></my-radio-button>
                    </div>
                </div>
                <div class="item-inline">
                    <div class="label">
                        <label :for=this.cfgtime.CTR_DATA_CHELTUIALA.id>{{this.cfgtime.CTR_DATA_CHELTUIALA.caption}}</label>
                    </div>
                    <div class="control">
                        <my-datetime
                            :ref = this.cfgtime.CTR_DATA_CHELTUIALA.ref
                            :pConfig = this.cfgtime.CTR_DATA_CHELTUIALA
                        ></my-datetime>
                    </div>
                </div>
                <div class="item-inline">
                    <div class="label">
                        <label :for=this.cfgtime.CTR_NR_DOCUMENT.id>{{this.cfgtime.CTR_NR_DOCUMENT.caption}}</label>
                    </div>
                    <div class="control">
                        <input-field
                            :ref = this.cfgtime.CTR_NR_DOCUMENT.ref
                            :pConfig = this.cfgtime.CTR_NR_DOCUMENT
                        ></input-field>
                    </div>
                </div>
            </div>

            <div class="ff-flex-form-end-align">
                <div class="item-column">
                    <div class="label">
                        <label :for=this.cfgtime.CTR_DOCUMENT_TYPE.id>{{this.cfgtime.CTR_DOCUMENT_TYPE.caption}}</label>
                    </div>
                    <div class="control">
                        <my-dropdown-simple
                            :pConfig = this.cfgtime.CTR_DOCUMENT_TYPE
                            :ref = this.cfgtime.CTR_DOCUMENT_TYPE.ref
                        ></my-dropdown-simple>
                    </div>
                </div>
                <div class="item-column">
                    <div class="label">
                        <label :for=this.cfgtime.CTR_TIP_CHELTUIELI.id>{{this.cfgtime.CTR_TIP_CHELTUIELI.caption}}</label>
                    </div>
                    <div class="control">
                        <my-dropdown-simple
                            :pConfig = this.cfgtime.CTR_TIP_CHELTUIELI
                            :ref = this.cfgtime.CTR_TIP_CHELTUIELI.ref
                        ></my-dropdown-simple>
                    </div>
                </div>
                <div class="item-column">
                    <div class="label">
                        <label :for=this.cfgtime.CTR_PARTNER_LIST.id>{{this.cfgtime.CTR_PARTNER_LIST.caption}}</label>
                    </div>
                    <div class="control">
                        <my-dropdown-search :ref = this.cfgtime.CTR_PARTNER_LIST.ref
                                            :pConfig = this.cfgtime.CTR_PARTNER_LIST
                        ></my-dropdown-search>
                    </div>
                </div>

                <div class="item-column">
                    <div class="control">
                        <div class="toolbar-icon-inline">
                            <div class="divButton">
                                &nbsp;&nbsp;
                                <my-button  :ref=this.cfgtime.REF_BUTTON_ADD_CHELT @click="this.serverAddNewChelt" :heightButton=22 :buttonType=2 title="adauga factura" :style="this.cfgtime.ICON_ADD_CHELT.colorStyle">
                                    <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.cfgtime.ICON_ADD_CHELT) size="1x" />
                                </my-button>
                            </div>

                            <div class="divButton">
                                <my-button  :ref=this.cfgtime.REF_BUTTON_REMOVE_CHELT @click="this.serverDeleteAntet" :heightButton=22 :buttonType=2 title="sterg factura" :style="this.cfgtime.ICON_REMOVE_CHELT.colorStyle">
                                    <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.cfgtime.ICON_REMOVE_CHELT) size="1x" />
                                </my-button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class = 'line'></div>
            <br>


            <!-- detaliu cheltuiei ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

            <div class="ff-flex-form">
                <div class="item-inline">
                    <div class="control">
                        <my-radio-button
                            :ref = this.cfgtime.CTR_TIP_SUMA.ref
                            :pConfig = this.cfgtime.CTR_TIP_SUMA
                            @emitClickTipSumaTva = 'emitClickTipSumaTva'
                        ></my-radio-button>
                    </div>
                </div>


                <div class="item-inline">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="control">
                        <check-box
                            :pConfig = this.cfgtime.CTR_SUMA_TVA_MANUALA
                            :ref= this.cfgtime.CTR_SUMA_TVA_MANUALA.ref
                            @emitSumaTvaManuala = 'emitSumaTvaManuala'
                        ></check-box>
                        <label class="label-bold" :for=this.cfgtime.CTR_SUMA_TVA_MANUALA.id>{{this.cfgtime.CTR_SUMA_TVA_MANUALA.caption}}</label>
                    </div>
                </div>


            </div>

            <div class="ff-flex-form">
                <div class="item-column">
                    <div class="label">
                        <label :for=this.cfgtime.CTR_CATEGORIE_CHELTUIALA.id>{{this.cfgtime.CTR_CATEGORIE_CHELTUIALA.caption}}</label>
                    </div>
                    <div class="control">
                        <my-dropdown-simple
                            :pConfig = this.cfgtime.CTR_CATEGORIE_CHELTUIALA
                            :ref = this.cfgtime.CTR_CATEGORIE_CHELTUIALA.ref
                        ></my-dropdown-simple>
                    </div>
                </div>
                <div class="item-column">
                    <div class="label">
                        <label :for=this.cfgtime.CTR_PRODUCT_LIST.id>{{this.cfgtime.CTR_PRODUCT_LIST.caption}}</label>
                    </div>
                    <div class="control">
                        <my-dropdown-search :ref = this.cfgtime.CTR_PRODUCT_LIST.ref
                                            :pConfig = this.cfgtime.CTR_PRODUCT_LIST
                        ></my-dropdown-search>
                    </div>
                </div>

            </div>

            <!-- ------------------------------------------------------------------------------------------------------------------------------- -->

            <div class="ff-flex-form">

                <div class="item-inline">
                    <div class="label">
                        <label :for=this.cfgtime.CTR_UM.id>{{this.cfgtime.CTR_UM.caption}}</label>
                    </div>
                    <div class="control">
                        <my-dropdown-simple
                            :pConfig = this.cfgtime.CTR_UM
                            :ref = this.cfgtime.CTR_UM.ref
                        ></my-dropdown-simple>
                    </div>
                </div>

                <div class="item-inline">
                    <div class="label">
                        <label :for=this.cfgtime.CTR_CANTITATE.id>{{this.cfgtime.CTR_CANTITATE.caption}}</label>
                    </div>
                    <div class="control">
                        <input-field
                            :ref = this.cfgtime.CTR_CANTITATE.ref
                            :pConfig = this.cfgtime.CTR_CANTITATE
                            @emitKeyUpCantitate = 'emitKeyUpCantitate'
                        ></input-field>
                    </div>
                </div>

                <div class="item-inline">
                    <div class="label" style="width: 150px">
                        <label :ref=this.cfgtime.REF_LABEL_SUMA :for=this.cfgtime.CTR_SUMA_UNITARA.id>{{this.cfgtime.CTR_SUMA_UNITARA.caption}}</label>
                    </div>
                    <div class="control">
                        <input-field
                            :ref = this.cfgtime.CTR_SUMA_UNITARA.ref
                            :pConfig = this.cfgtime.CTR_SUMA_UNITARA
                            @emitKeyUpSuma = 'emitKeyUpSuma'
                        ></input-field>
                    </div>
                </div>

                <div class="item-inline">
                    <div class="label">
                        <label :for=this.cfgtime.CTR_SUMA_TOTAL_TVA.id>{{this.cfgtime.CTR_SUMA_TOTAL_TVA.caption}}</label>
                    </div>
                    <div class="control">
                        <input-field
                            :ref = this.cfgtime.CTR_SUMA_TOTAL_TVA.ref
                            :pConfig = this.cfgtime.CTR_SUMA_TOTAL_TVA
                        ></input-field>
                    </div>
                </div>

                <div class="item-inline">
                    <div class="label">
                        <label :for=this.cfgtime.CTR_SUMA_PRETUNITAR_FARA_TVA.id>{{this.cfgtime.CTR_SUMA_PRETUNITAR_FARA_TVA.caption}}</label>
                    </div>
                    <div class="control">
                        <input-field
                            :ref = this.cfgtime.CTR_SUMA_PRETUNITAR_FARA_TVA.ref
                            :pConfig = this.cfgtime.CTR_SUMA_PRETUNITAR_FARA_TVA
                        ></input-field>
                    </div>
                </div>

                <div class="item-inline">
                    <div class="label">
                        <label :for=this.cfgtime.CTR_PROCENT_TVA.id>{{this.cfgtime.CTR_PROCENT_TVA.caption}}</label>
                    </div>
                    <div class="control">
                        <input-field
                            :ref = this.cfgtime.CTR_PROCENT_TVA.ref
                            :pConfig = this.cfgtime.CTR_PROCENT_TVA
                            @emitKeyUpPercenTVA = 'emitKeyUpPercenTVA'
                        ></input-field>
                    </div>
                </div>


                <div class="item-inline">
                    <div class="control">
                        <div class="buttons">
                            <my-button :ref=this.cfgtime.REF_BUTTON_ADD_ITEM @click="this.serverAddArticol" :heightButton=22 :buttonType=0 title="adaug articol in factura">Adaug</my-button>
                        </div>
                    </div>
                </div>


            </div>


            <my-list
                    :ref = this.cfgtime.CTR_EXPENSE_DETAIL_LIST.ref
                    :pConfig=this.cfgtime.CTR_EXPENSE_DETAIL_LIST
                    @emitListRowSelection = 'emitDetailListRowSelection'
                    @emitStergArticol = 'emitStergArticol'
                    @emitFinallyCustomResponse = 'emitListaSumary'
            ></my-list>



        </template>
        <template v-slot:slotButton>
        </template>
    </form-tab>
</template>

<script>
    import AlertWindow      from "@/components/base/AlertWindow.vue";
    import FormTab          from "@/components/base/FormTab.vue";
    import RadioButton      from "@/components/base/RadioButton.vue";
    import InputDateTime    from "@/components/base/InputDateTime.vue";
    import InputField       from "@/components/base/InputField.vue";
    import DropDownSimple   from "@/components/base/DropDownSimple.vue";
    import DropDownSearch   from "@/components/base/DropDownSearch.vue"
    import Button           from "@/components/base/Button";
    import CheckBox         from "@/components/base/CheckBox.vue";
    import Lista            from "@/components/base/Lista";

    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
	        'my-radio-button': RadioButton,
	        'my-datetime': InputDateTime,
	        'input-field': InputField,
	        'my-dropdown-simple': DropDownSimple,
	        'my-dropdown-search': DropDownSearch,
            'my-button': Button,
            'check-box': CheckBox,
	        'my-list': Lista
        },
        name: "form-chletuiala-new",
        created() {
            this.REF_FORM = 'refCheltuialaNew';
            this.cfgtime ={
                REF_LABEL_SUMA: 'refLabelSuma',
                REF_BUTTON_ADD_CHELT:     'refAddChelt',
                REF_BUTTON_REMOVE_CHELT:  'refRemoveChelt',
                REF_BUTTON_ADD_ITEM:        'refAddItem',
	            TIP_PLATA: {
		            id: 'refTipPlata',
		            ref: 'refTipPlata',
		            caption: 'Tip plata',
		            alignment: this.$constRadioButton.ALIGNMENT_H,
		            name: 'tipPlata',
		            emit: 'emitClickTipPlata',
		            buttons:[
			            {id: 1, value: '1', caption: 'Numerar', check: true, disableOption: false },
			            {id: 2, value: '2', caption: 'Banca', check: false, disableOption: false }
		            ]
	            },
                CTR_DATA_CHELTUIALA: this.cfgDataCheltuiala(),
	            CTR_NR_DOCUMENT:    this.cfgNrDoc(),
	            CTR_DOCUMENT_TYPE:  this.cfgDocumentType(),
	            CTR_TIP_CHELTUIELI: this.cfgCheltuieliType(),
	            CTR_PARTNER_LIST:   this.cfgDropDownPartner(),
                ICON_ADD_CHELT:     this.$constComponent.ICON_PLUS_SQUARE("blue"),
                ICON_REMOVE_CHELT:  this.$constComponent.ICON_MINUS_SQUARE("red"),
                URL_INSERT_ANTET:   this.$url.getUrl('insertExpenseAntet'),
                URL_INSERT_ARTICOL:   this.$url.getUrl('insertExpenseArticol'),
                URL_CHECK_WORKING_EXPENSE: this.$url.getUrl('checkWorkingExpense'),
                URL_DELETE_EXPENSE: this.$url.getUrl('deleteAntetExpense'),
                URL_DELETE_ITEM_EXPENSE: this.$url.getUrl('deleteExpenseArticol'),
                CTR_TIP_SUMA: {
                    id:         'refTipSuma',
                    ref:        'refTipSuma',
                    caption:    'Suma',
                    alignment: this.$constRadioButton.ALIGNMENT_H,
                    name:       'tipSumaTva',
                    emit:       'emitClickTipSumaTva',
                    buttons:[
                        {id: 1, value: '1', caption: 'Suma totala fara TVA', check: true, disableOption: false },
                        {id: 2, value: '2', caption: 'Suma totala cu TVA', check: false, disableOption: false }
                    ]
                },
                CTR_CATEGORIE_CHELTUIALA:  this.cfgCategoriiCheltuieli(),
                CTR_PRODUCT_LIST:   this.cfgDropDownProducts(),
                CTR_UM:  this.cfgUm(),
                CTR_CANTITATE: this.cfgCantitate(),
                CTR_SUMA_UNITARA: this.cfgSumaUnitara(),
                CTR_SUMA_TOTAL_TVA: this.cfgSumaTVA(),
                CTR_SUMA_PRETUNITAR_FARA_TVA: this.cfgPretUnitarFaraTva(),
                CTR_PROCENT_TVA: this.cfgTva(),
                CTR_SUMA_TVA_MANUALA: this.cfgSumaTvaManuala(),
	            CTR_EXPENSE_DETAIL_LIST : {
		            ref: 'refDetailList',
		            header: [
			            this.$constList.getHeader(1, 'Nr.'              ,20     ,'row_num'          , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER  ),
			            this.$constList.getHeader(2, 'Cat'              ,100    ,'tip_cat'          , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER ),
			            this.$constList.getHeader(3, 'Nume produs'      ,500    ,'produs'           , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_LEFT  ),
			            this.$constList.getHeader(4, 'UM'               ,30     ,'um'               , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER  ),
			            this.$constList.getHeader(5, 'Cantitate'        ,80     ,'cantitate'        , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER  ),
			            this.$constList.getHeader(6, 'Pret unitar'      ,100    ,'pret_unitar'      , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT  ),
			            this.$constList.getHeader(7, 'Valoare fara TVA' ,110    ,'total_fara_tva'   , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT  ),
			            this.$constList.getHeader(8, 'Valoare TVA'      ,100    ,'total_tva'        , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT  ),
			            this.$constList.getHeader(9, 'Total'            ,90     ,'total'            , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT  ),
			            this.$constList.getHeader(10, '% TVA'           ,70     ,'procent_tva'      , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT  ),

			            this.$constList.getHeader(20, 'Action'       ,100    ,'null', this.$constList.HEADER.CAPTION_TYPE_ACTION)
		            ],
		            recordActionButon: [
			            this.$constList.getActionButton(4, 'sterg articol', 'emitStergArticol', this.$constGrid.ICON_DELETE, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null)
			            //this.$constList.getActionButton(5, 'adresa implicita', 'emitAdresaImplicita', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('ro', false)),   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
			            // this.$constList.getActionButton(6, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00'))
		            ],
		            cfg: { urlData: 'detailExpenseList', loadOnCreate: false,
			            filedNameForCheckBox: 'activ',
			            headerLenghtActivate: true,                         // tine cont de lungimea coloanelor setate in header
			            emitListRowSelection: 'emitListRowSelection'}
	            },
            },
            this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
	            antetData: null,
                yesNoMethod: 'methodName',
                calculezTvaManual: false,
                post: { idPk: null, field: {}, sqlAction: null},
                postArticol: { idPk: null, idExpense: null, field: {}, sqlAction: null},
                sumaTotalaCuTva: 0                                                             // valoare la calcul interactiv
            }
        },
        emits: ['emitModel'],
        mounted () {
        },
        methods: {
            serverAddArticol: function (){
                if(this.validateNewArticol()){
                    this.$refs.validateWindowRef.show();
                    return false;
                }

                this.$refs[this.REF_FORM].showModal(true);
                this.axios
                    .post(this.cfgtime.URL_INSERT_ARTICOL, this.runtime.postArticol)
                    .then(response => {
                        if (response.data.succes) {
                        }
                        else {
                        }
                    })
                    .catch(error => console.log(error))
                    .finally(() => {
                    	this.showListItems();
                        this.$refs[this.REF_FORM].showModal(false);
                    });
            },
            serverAddNewChelt: function (){
	            if(this.validateNewDoc()){
		            this.$refs.validateWindowRef.show();
		            return false;
	            }

	            this.$refs[this.REF_FORM].showModal(true);

	            this.axios
		            .post(this.cfgtime.URL_INSERT_ANTET, this.runtime.post)
		            .then(response => {
			            if (response.data.succes){

				            //this.getDataPartener(this.post.idPk);
				            //this.$refs.infoWindowRef.setCaption("Succes");
				            //this.$refs.infoWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
				            //this.$refs.infoWindowRef.show();
			            }
			            else {
				            this.$refs.validateWindowRef.setCaption("Antetul nu poate fi inregistrat");
				            this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
				            this.$refs.validateWindowRef.show();
			            }

		            })
		            .catch(error => console.log(error))
		            .finally(() => {
			            this.serverCheckWorkingExpense();
			            this.$refs[this.REF_FORM].showModal(false);
    	            });

            },
            serverDeleteAntet: function () {
	            if(!this.runtime.sendDataToServer){
	            	this.runtime.yesNoMethod = 'serverDeleteAntet';
		            this.$refs.refYesNo.setCaption("Sterg cheltuiala?");
		            this.$refs.refYesNo.setMessage("Datele sterse nu mai pot fi recuperate.");
		            this.$refs.refYesNo.show();
	            }

	            if(this.runtime.sendDataToServer){
		            this.runtime.sendDataToServer = false;

                    this.runtime.post.idPk = this.runtime.antetData.id;

                    this.$refs[this.REF_FORM].showModal(true);

                    this.axios
                        .post(this.cfgtime.URL_DELETE_EXPENSE, this.runtime.post)
                        .then(response => {
                            if (response.data.succes){
                            }
                            else {
                                this.$refs.validateWindowRef.setCaption("Nu se poate sterge documentul");
                                this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
                                this.$refs.validateWindowRef.show();
                            }

                        })
                        .catch(error => console.log(error))
                        .finally(() => {
                            this.serverCheckWorkingExpense();
                            this.$refs[this.REF_FORM].showModal(false);
                        });
                }

            },
	        serverCheckWorkingExpense: function() {
		        this.$refs[this.REF_FORM].showModal(true);
		        this.axios
			        .post(this.cfgtime.URL_CHECK_WORKING_EXPENSE)
			        .then(response => {
				        if (response.data.succes) {
					        // console.log(response.data.records.length);
					        if(response.data.records.length > 0){
						        this.runtime.antetData = response.data.records[0];
					        }else{
						        this.runtime.antetData = null;
					        }
				        }
				        else {

				        }
			        })
			        .catch(error => console.log(error))
			        .finally(() => {
				        this.fillAFormAntet();
				        //this.showListItems();
                        //console.log(this.runtime.antetData);
				        this.$refs[this.REF_FORM].showModal(false);
			        });
	        },
            serverDeleteItemChelt: function (){
                if(!this.runtime.sendDataToServer){
                    this.runtime.yesNoMethod = 'serverDeleteItemChelt';
                    this.$refs.refYesNo.setCaption("Sterg inregistrarea?");
                    this.$refs.refYesNo.setMessage("Datele sterse nu mai pot fi recuperate.");
                    this.$refs.refYesNo.show();
                }

                if(this.runtime.sendDataToServer) {
                    this.runtime.sendDataToServer = false;

                    this.axios
                        .post(this.cfgtime.URL_DELETE_ITEM_EXPENSE, this.runtime.post)
                        .then(response => {
                            if (response.data.succes){
                            }
                            else {
                                this.$refs.validateWindowRef.setCaption("Nu se poate sterge elementul");
                                this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
                                this.$refs.validateWindowRef.show();
                            }

                        })
                        .catch(error => console.log(error))
                        .finally(() => {
                            this.showListItems();
                            this.$refs[this.REF_FORM].showModal(false);
                        });
                }
            },
	        emitStergArticol: function (button){
		        let tr = button.closest('tr');
		        this.runtime.post.idPk = tr.getAttribute('idPk');

		        this.serverDeleteItemChelt();
	        },
	        emitListaSumary: function (sumarInvoice) {
                console.log(sumarInvoice);
	        },
	        emitDetailListRowSelection: function () {
                // do nothing
	        },
	        showListItems: function(){

		        let $id = 0;
		        if(!this.$check.isUndef(this.runtime.antetData)){
			        $id = this.runtime.antetData.id;
		        }
		        this.$refs[this.cfgtime.CTR_EXPENSE_DETAIL_LIST.ref].showList({idExpense: $id});
	        },
            emitKeyUpPercenTVA: function (value){
                this.privateCalculateTVA('from emitKeyUpPercenTVA');
            },
            emitKeyUpSuma: function (value){
                this.privateCalculateTVA('from emitKeyUpSuma');
            },
            emitKeyUpCantitate: function (value){
                // console.log(value);
                this.privateCalculateTVA('from KeyUpCantitate');
            },
            emitClickTipSumaTva: function (){

                let tipSuma = this.$refs[this.cfgtime.CTR_TIP_SUMA.ref].getValue();

                for(let i=0;i < this.cfgtime.CTR_TIP_SUMA.buttons.length; i++){
                    if(tipSuma == this.cfgtime.CTR_TIP_SUMA.buttons[i].id){
                        this.$refs[this.cfgtime.REF_LABEL_SUMA].innerHTML = this.cfgtime.CTR_TIP_SUMA.buttons[i].caption;
                    }
                }



                this.privateCalculateTVA('from emitClickTipSumaTva');
            },
            emitSumaTvaManuala: function (checkBoxControl){

                this.runtime.calculezTvaManual = checkBoxControl.checked;

                this.$refs[this.cfgtime.CTR_SUMA_TOTAL_TVA.ref].setReadOnly(!this.runtime.calculezTvaManual);

                if(this.runtime.calculezTvaManual){
                    this.$refs[this.cfgtime.CTR_SUMA_TOTAL_TVA.ref].setValue(0);
                }

                this.privateCalculateTVA('from emitSumaTvaManuala');
            },
            privateCalculateTVA: function (sourceClick){
                //console.log(sourceClick); // for debug

                let tipSuma = this.$refs[this.cfgtime.CTR_TIP_SUMA.ref].getValue();
                let suma = this.$refs[this.cfgtime.CTR_SUMA_UNITARA.ref].getValue();
                let tva = this.$refs[this.cfgtime.CTR_PROCENT_TVA.ref].getValue();
                let cantitate = this.$refs[this.cfgtime.CTR_CANTITATE.ref].getValue();

                let calculRezult = this.$calculate.tva(tipSuma, suma, tva, cantitate);

                if(!this.runtime.calculezTvaManual){
                    this.$refs[this.cfgtime.CTR_SUMA_TOTAL_TVA.ref].setValue(calculRezult.sumaTVA);
                }
                this.$refs[this.cfgtime.CTR_SUMA_PRETUNITAR_FARA_TVA.ref].setValue(calculRezult.pretUnitarFaraTva);

                // valoare cu TVA
                // if(tipSuma == 2){this.$refs[this.cfgtime.CTR_SUMA_UNITARA.ref].setValue(calculRezult.sumaFaraTVA);}

                // console.log(calculRezult);
                // tva: function(tipSuma, suma, percentTVA, cantitate){

                this.runtime.sumaTotalaCuTva = calculRezult.sumaFaraTVA;

            },
	        emitClickTipPlata: function (){
            },
	        fillAFormAntet: function (){
		        if(this.$check.isUndef(this.runtime.antetData)){
			        this.setModeForm(this.$constFROM.MODE_NEW);
			        this.runtime.post.idPk = null;

			        this.$refs[this.cfgtime.TIP_PLATA.ref].resetSelection();
			        // this.$refs[this.cfgtime.CTR_DATA_CHELTUIALA.ref].resetDataSelected();
                    this.$refs[this.cfgtime.CTR_NR_DOCUMENT.ref].setValue('');

			        this.$refs[this.cfgtime.CTR_DOCUMENT_TYPE.ref].setValue(this.cfgtime.CTR_DOCUMENT_TYPE.getDefaultValue().id);
			        this.$refs[this.cfgtime.CTR_TIP_CHELTUIELI.ref].setValue(this.cfgtime.CTR_TIP_CHELTUIELI.getDefaultValue().id);

			        this.$refs[this.cfgtime.CTR_PARTNER_LIST.ref].resetDataSelected();
			        this.$refs[this.cfgtime.CTR_PARTNER_LIST.ref].clearWordSearch();

		        }else{
			        this.setModeForm(this.$constFROM.MODE_EDIT);

			        this.runtime.post.idPk = this.runtime.antetData.id;
			        this.runtime.postArticol.idExpense = this.runtime.antetData.id;

			        this.$refs[this.cfgtime.TIP_PLATA.ref].setCheck(this.runtime.antetData.id_tipplata);
			        this.$refs[this.cfgtime.CTR_DATA_CHELTUIALA.ref].setValueFromSqlFormat(this.runtime.antetData.datac);
			        this.$refs[this.cfgtime.CTR_NR_DOCUMENT.ref].setValue(this.runtime.antetData.cNrDoc);
			        this.$refs[this.cfgtime.CTR_PARTNER_LIST.ref].setDataSelected( {id: this.runtime.antetData.id_part, caption: this.runtime.antetData.partner_name} );
			        this.$refs[this.cfgtime.CTR_DOCUMENT_TYPE.ref].setValue(this.runtime.antetData.id_tipd);
			        this.$refs[this.cfgtime.CTR_TIP_CHELTUIELI.ref].setValue(this.runtime.antetData.id_tipc);


		        }

		        this.showListItems();
	        },
            setModeForm: function (mode) {
                this.runtime.mode = mode;
	            let readOnly = true;

                if(this.runtime.mode == this.$constFROM.MODE_EDIT) {
	                readOnly = true;
	                this.$refs[this.cfgtime.REF_BUTTON_ADD_CHELT].disable(readOnly);
	                this.$refs[this.cfgtime.REF_BUTTON_REMOVE_CHELT].disable(false);
                    this.$refs[this.cfgtime.REF_BUTTON_ADD_ITEM].disable(false);
                }

                if(this.runtime.mode == this.$constFROM.MODE_NEW) {
	                readOnly = false;
	                this.$refs[this.cfgtime.REF_BUTTON_ADD_CHELT].disable(readOnly);
	                this.$refs[this.cfgtime.REF_BUTTON_REMOVE_CHELT].disable(true);
                    this.$refs[this.cfgtime.REF_BUTTON_ADD_ITEM].disable(true);

                }

	            this.$refs[this.cfgtime.CTR_TIP_CHELTUIELI.ref].setReadOnly(readOnly);
	            this.$refs[this.cfgtime.TIP_PLATA.ref].disabledAll(readOnly);
	            this.$refs[this.cfgtime.CTR_DATA_CHELTUIALA.ref].setReadOnly(readOnly);
	            this.$refs[this.cfgtime.CTR_NR_DOCUMENT.ref].setReadOnly(readOnly);
	            this.$refs[this.cfgtime.CTR_PARTNER_LIST.ref].setReadOnly(readOnly);
	            this.$refs[this.cfgtime.CTR_DOCUMENT_TYPE.ref].setReadOnly(readOnly);
	            this.$refs[this.cfgtime.CTR_TIP_CHELTUIELI.ref].setReadOnly(readOnly);

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
            setPostArticol: function (component, value){
                this.runtime.postArticol['field'][component.name] = value;
            },
            validateNewArticol: function (){
                let returnMessage = false;
                this.runtime.message = [];

                let validateArray = [
                    this.$refs[this.cfgtime.CTR_CATEGORIE_CHELTUIALA.ref],
                    this.$refs[this.cfgtime.CTR_PRODUCT_LIST.ref],
                    this.$refs[this.cfgtime.CTR_UM.ref],
                    this.$refs[this.cfgtime.CTR_CANTITATE.ref],
                    this.$refs[this.cfgtime.CTR_SUMA_UNITARA.ref],
                    this.$refs[this.cfgtime.CTR_SUMA_PRETUNITAR_FARA_TVA.ref],
                    this.$refs[this.cfgtime.CTR_SUMA_TOTAL_TVA.ref],
                    this.$refs[this.cfgtime.CTR_PROCENT_TVA.ref],


                ];

                this.$check.validateForm(validateArray);

                if( this.runtime.message.length>0 ){
                    this.$refs.validateWindowRef.setCaption("Articolul nu poate fi inregistrat");
                    this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.runtime.message));
                    returnMessage = true;
                }

                return returnMessage;
            },
	        validateNewDoc: function (){
		        let returnMessage = false;
		        this.runtime.message = [];

		        let validateArray = [this.$refs[this.cfgtime.TIP_PLATA.ref],
                                     this.$refs[this.cfgtime.CTR_DATA_CHELTUIALA.ref],
                                     this.$refs[this.cfgtime.CTR_NR_DOCUMENT.ref],
			                         this.$refs[this.cfgtime.CTR_DOCUMENT_TYPE.ref],
                                     this.$refs[this.cfgtime.CTR_TIP_CHELTUIELI.ref],
			                         this.$refs[this.cfgtime.CTR_PARTNER_LIST.ref]
                                    ];

		        this.$check.validateForm(validateArray);

		        if( this.runtime.message.length>0 ){
			        this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
			        this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.runtime.message));
			        returnMessage = true;
		        }

		        return returnMessage;
            },
            validateSumaPretUnitarFaraTva: function (){
                let control = this.cfgtime.CTR_SUMA_PRETUNITAR_FARA_TVA;
                let value = +(this.$refs[control.ref].getValue());

                if(!this.$check.isNumber(value)){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Suma trebuie fie o valoare numerica!"));
                }else if(value == 0){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Pretul unitar trebuie sa fie mai mare ca zero!"));
                }
                this.setPostArticol(control, value);
            },
            validateSumaTVA: function (){
                let control = this.cfgtime.CTR_SUMA_TOTAL_TVA;
                let value = +(this.$refs[control.ref].getValue());

                if(!this.$check.isNumber(value)){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Suma trebuie fie o valoare numerica!"));
                }
                this.setPostArticol(control, value);
            },
            validateTVA: function (){
                let control = this.cfgtime.CTR_PROCENT_TVA;
                let value = +(this.$refs[control.ref].getValue());

                if(!this.$check.isNumber(value)){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Procentul trebuie fie o valoare numerica!"));
                }
                this.setPostArticol(control, value);
            },
            validateSumaUnitara: function (){
                let control = this.cfgtime.CTR_SUMA_UNITARA;
                let value =  +(this.runtime.sumaTotalaCuTva); // suma calculata fara TVA// +(this.$refs[control.ref].getValue());

                if(!this.$check.isNumber(value)){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Suma trebuie sa fie o valoare numerica!"));
                }
                this.setPostArticol(control, value);
            },
            validateCantitate: function (){
                let control = this.cfgtime.CTR_CANTITATE;
                let value = +(this.$refs[control.ref].getValue());

                if(!this.$check.isNumber(value)){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Cantitatea trebuie sa fie o valoare numerica!"));
                }else if(value == 0){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Cantitatea trebuie sa fie diferita de ZERO!"));
                }

                this.setPostArticol(control, value);
            },
	        validateDocumentDate : function (){
		        let control = this.cfgtime.CTR_DATA_CHELTUIALA;
		        let value = this.$refs[control.ref].getValue();
		        let splitDate = this.$refs[control.ref].getSplitValue();

		        if(!this.$check.isExistDate(splitDate, true)){
			        this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
				        "Data documentului este gresita!"));
		        }


		        let control01 = this.cfgtime.TIP_PLATA;
		        let valueTipincasare = this.$refs[control01.ref].getValue();

		        if(this.$check.isUndef(valueTipincasare)){
			        this.runtime.message.push(this.$app.getFormMessageClass(control.id, control01.caption,
				        "Trebuie sa alegi tipul de incasare"));
		        }

		        this.setPost(control01, valueTipincasare);
		        this.setPost(control, value);

            },
	        validateNrDoc: function (){
		        // include si validateDocumentDate
		        let objNrDoc = this.cfgtime.CTR_NR_DOCUMENT;
		        let valueManualNumber = this.$refs[objNrDoc.ref].getValue();

                if(!this.$check.lenghtMinMax(valueManualNumber, objNrDoc.minLength, objNrDoc.maxLength)){
                    this.runtime.message.push(this.$app.getFormMessageClass(objNrDoc.id, objNrDoc.caption,
                        'trebuie sa aiba minim ' + objNrDoc.minLength + " si maxim " + objNrDoc.maxLength + " caractere"));
                }

		        this.setPost(objNrDoc, valueManualNumber);

            },
	        validateCheltuieliType: function (){
		        let control = this.cfgtime.CTR_TIP_CHELTUIELI;
		        let value = this.$refs[control.ref].getValue();
		        let id = -1;

		        if (this.$check.isUndef(value) || parseInt(value.id) < 1) {
			        this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
				        "Trebuie sa alegi tipul de cheltuiala."));
		        } else {
			        id = value.id;
		        }

		        this.setPost(control, id);
            },
	        validateInvoiceType: function (){
		        let control = this.cfgtime.CTR_DOCUMENT_TYPE;
		        let value = this.$refs[control.ref].getValue();
		        let id = -1;

		        if (this.$check.isUndef(value) || parseInt(value.id) < 1) {
			        this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
				        "Trebuie sa alegi tipul de document."));
		        } else {
			        id = value.id;
		        }

		        this.setPost(control, id);
            },
	        validatePartner: function (){
		        let control = this.cfgtime.CTR_PARTNER_LIST;
		        let value = this.$refs[control.ref].getValue();
		        let id = -1;

		        if( this.$check.isUndef(value) || parseInt(value.id) < 1){
			        this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
				        "Trebuie sa alegi un partener"));
		        }else{
			        id = value.id;
		        }

		        this.setPost(control, id);

            },
            validateUm: function (){
                let control = this.cfgtime.CTR_UM;

                let value = this.$refs[control.ref].getValue();
                let id = -1;

                if (this.$check.isUndef(value) || parseInt(value.id) < 1) {
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Trebuie sa alegi unitatea de masura."));
                } else {
                    id = value.id;
                }

                this.setPostArticol(control, id);
            },
            validateProduct: function (){
                let control = this.cfgtime.CTR_PRODUCT_LIST;
                let value = this.$refs[control.ref].getValue();
                let id = -1;

                if( this.$check.isUndef(value) || parseInt(value.id) < 1){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Trebuie sa alegi un produs"));
                }else{
                    id = value.id;
                }

                this.setPostArticol(control, id);
            },
            validateCategoriCheltuieli: function(){
                let control = this.cfgtime.CTR_CATEGORIE_CHELTUIALA;

                let value = this.$refs[control.ref].getValue();
                let id = -1;

                if (this.$check.isUndef(value) || parseInt(value.id) < 1) {
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Trebuie sa alegi categoria de cheltuiala."));
                } else {
                    id = value.id;
                }

                this.setPostArticol(control, id);
            },
	        cfgDataCheltuiala: function(){
		        let cfg = this.$app.cfgInputDateTimeField("dataCheltuiala", 11, 80);
		        cfg.setValidateFunction(this.validateDocumentDate);
		        cfg.setCaption("Data");
		        cfg.setMandatory(true);
		        return cfg;
	        },
	        cfgNrDoc: function(){
		        let cfg = this.$app.cfgInputField("nrDoc", null, 120);
		        cfg.setValidate(2,20);
		        cfg.setValidateFunction(this.validateNrDoc);
		        cfg.setCaption("Nr. document");
		        cfg.setMandatory(true);
		        cfg.setMaska("");
		        return cfg;
	        },
	        cfgCheltuieliType: function (){
		        let cfg = this.$app.cfgSelectSimple('nomTypeCheltuieli', this.$url.getUrl('nomTipCheltuieli'), 200);
		        cfg.setValidateFunction(this.validateCheltuieliType);
		        cfg.setCaption("Tip cheltuiala");
		        cfg.setMandatory(true);
		        cfg.setPlaceHolder('... (tip cheltuiala)');
		        cfg.setDefaultValue({id: 0, text: '... (tip cheltuiala)'});
		        return cfg;
            },
	        cfgDocumentType: function(){
		        let cfg = this.$app.cfgSelectSimple('nomDocumentType', this.$url.getUrl('nomDocumentTipe'), 200);
		        cfg.setValidateFunction(this.validateInvoiceType);
		        cfg.setCaption("Tip document");
		        cfg.setMandatory(true);
		        cfg.setPlaceHolder('... (tip document)');
		        cfg.setDefaultValue({id: 0, text: '... (tip document)'});
		        return cfg;
	        },
	        cfgDropDownPartner: function(){
		        let cfg = this.$app.cfgSelectSearch('nomPartner', this.$url.getUrl('listPartener'), 450);
		        cfg.setValidateFunction(this.validatePartner);
		        cfg.setCaption("Furnizor");
		        cfg.setMandatory(true);
		        return cfg;
	        },
            cfgCategoriiCheltuieli: function(){
                let cfg = this.$app.cfgSelectSimple('nomCategoriCheltuieli', this.$url.getUrl('nomCategoriCheltuieli'), 270);
                cfg.setValidateFunction(this.validateCategoriCheltuieli);
                cfg.setCaption("Categorie cheltuiala");
                cfg.setMandatory(true);
                cfg.setPlaceHolder('... (cat. cheltuiala)');
                cfg.setDefaultValue({id: 0, text: '... (cat. cheltuiala)'});
                return cfg;
            },
            cfgDropDownProducts: function(){
                let cfg = this.$app.cfgSelectSearch('nomProducts', this.$url.getUrl('listProducts'), 450);
                cfg.setValidateFunction(this.validateProduct);
                cfg.setCaption("Produse");
                cfg.setMandatory(true);
                return cfg;
            },
            cfgUm: function(){
                let cfg = this.$app.cfgSelectSimple('nomUm', this.$url.getUrl('nomTipUm'), 170);
                cfg.setValidateFunction(this.validateUm);
                cfg.setCaption("Unitate de masura");
                cfg.setMandatory(true);
                cfg.setPlaceHolder('... (unitate de masura)');
                cfg.setDefaultValue({id: 0, text: '... (unitate de masura)'});
                return cfg;
            },
            cfgCantitate: function(){
                let cfg = this.$app.cfgInputField("cantitate", null, 65);
                cfg.setValidate(2,20);
                cfg.setValidateFunction(this.validateCantitate);
                cfg.setCaption("Cantitate");
                cfg.setMandatory(true);
                cfg.setMaska("");
                cfg.setEmitKeyUp('emitKeyUpCantitate');
                cfg.setDefaultValue(1);
                return cfg;
            },
            cfgSumaUnitara: function(){
                let cfg = this.$app.cfgInputField("sumaUnitara", null, 70);
                cfg.setValidate(2,20);
                cfg.setValidateFunction(this.validateSumaUnitara);
                cfg.setCaption("Suma totala fara TVA");
                cfg.setMandatory(true);
                cfg.setMaska("");
                cfg.setEmitKeyUp('emitKeyUpSuma');
                cfg.setDefaultValue(0);
                return cfg;
            },
            cfgSumaTVA: function(){
                let cfg = this.$app.cfgInputField("sumaTva", null, 70);
                cfg.setValidate(2,20);
                cfg.setValidateFunction(this.validateSumaTVA);
                cfg.setCaption("Total TVA");
                cfg.setMandatory(true);
                cfg.setMaska("");
                cfg.readOnly = true;
                cfg.setDefaultValue(0);
                return cfg;
            },
            cfgPretUnitarFaraTva: function(){
                let cfg = this.$app.cfgInputField("sumaPretUnitarFaraTva", null, 70);
                cfg.setValidate(2,20);
                cfg.setValidateFunction(this.validateSumaPretUnitarFaraTva);
                cfg.setCaption("Pret unitar fara tva");
                cfg.setMandatory(true);
                cfg.setMaska("");
                cfg.readOnly = true;
                cfg.setDefaultValue(0);
                return cfg;
            },
            cfgTva: function(){
                let cfg = this.$app.cfgInputField("tva", null, 40);
                cfg.setValidateFunction(this.validateTVA);
                cfg.setCaption("TVA");
                cfg.setMandatory(true);
                cfg.setMaska("");
                cfg.setEmitKeyUp('emitKeyUpPercenTVA');
                cfg.setDefaultValue(19);
                return cfg;
            },
            cfgSumaTvaManuala: function (){
                let cfg = this.$app.cfgCheckBox('sumaTvaManuala', false);
                cfg.setEmit('emitSumaTvaManuala');
                cfg.setCaption('Calculez tva manual');
                cfg.setValidateFunction(this.validateTvaManual);
                return cfg;
            }
        },
        data () {
            return {
            }
        }
    }

</script>

<style scoped></style>
