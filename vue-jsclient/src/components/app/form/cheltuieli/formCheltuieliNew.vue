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
            <table class="ff-form-table">
                <tr>
                    <td class="control">
                        <my-radio-button
                                :ref = this.cfgtime.TIP_PLATA.ref
                                :pConfig = this.cfgtime.TIP_PLATA
                                @emitClickTipPlata = 'emitClickTipPlata'
                        ></my-radio-button>
                    </td>
                    <td class="label-left bold" colspan="1">
                        &nbsp;&nbsp;&nbsp;
                        <label :for=this.cfgtime.CTR_DATA_CHELTUIALA.id>{{this.cfgtime.CTR_DATA_CHELTUIALA.caption}} &nbsp;</label>
                        <my-datetime
                                :ref = this.cfgtime.CTR_DATA_CHELTUIALA.ref
                                :pConfig = this.cfgtime.CTR_DATA_CHELTUIALA
                        ></my-datetime>
                    </td>

                    <td class="label-left bold">
                        &nbsp;
                        <label :for=this.cfgtime.CTR_NR_DOCUMENT.id>{{this.cfgtime.CTR_NR_DOCUMENT.caption}}</label></td>
                    <td>
                        <input-field
                                :ref = this.cfgtime.CTR_NR_DOCUMENT.ref
                                :pConfig = this.cfgtime.CTR_NR_DOCUMENT
                        ></input-field>
                        &nbsp;
                        &nbsp;
                    </td>
                    <td class="label-left bold" colspan="2">
                        <my-dropdown-simple
                                :pConfig = this.cfgtime.CTR_DOCUMENT_TYPE
                                :ref = this.cfgtime.CTR_DOCUMENT_TYPE.ref
                        ></my-dropdown-simple>
                    </td>
                    <td class="label-left bold" colspan="2">
                        <my-dropdown-simple
                                :pConfig = this.cfgtime.CTR_TIP_CHELTUIELI
                                :ref = this.cfgtime.CTR_TIP_CHELTUIELI.ref
                        ></my-dropdown-simple>
                    </td>
                </tr>
                <tr>

                    <td class="label-right bold">
                        &nbsp;
                        <label :for=this.cfgtime.CTR_PARTNER_LIST.id>{{this.cfgtime.CTR_PARTNER_LIST.caption}}</label></td>

                    <td class="control" colspan="4">
                        <my-dropdown-search :ref = this.cfgtime.CTR_PARTNER_LIST.ref
                                            :pConfig = this.cfgtime.CTR_PARTNER_LIST
                        ></my-dropdown-search>
                    </td>

                    <td class="control">
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
                    </td>
                </tr>
            </table>
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

    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
	        'my-radio-button': RadioButton,
	        'my-datetime': InputDateTime,
	        'input-field': InputField,
	        'my-dropdown-simple': DropDownSimple,
	        'my-dropdown-search': DropDownSearch,
            'my-button': Button
        },
        name: "form-chletuiala-new",
        created() {
            this.REF_FORM = 'refCheltuialaNew';
            this.cfgtime = {
                REF_BUTTON_ADD_CHELT:     'refAddChelt',
                REF_BUTTON_REMOVE_CHELT:  'refRemoveChelt',
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
                URL_CHECK_WORKING_EXPENSE: this.$url.getUrl('checkWorkingExpense'),
                URL_DELETE_EXPENSE: this.$url.getUrl('deleteAntetExpense')

            },
            this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
	            antetData: null,
                yesNoMethod: 'methodName',
                post: { idPk: null, field: {}, sqlAction: null}
            }
        },
        emits: ['emitModel'],
        mounted () {
        },
        methods: {
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
            deleteChelt: function (){
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

			        this.$refs[this.cfgtime.TIP_PLATA.ref].setCheck(this.runtime.antetData.id_tipplata);
			        this.$refs[this.cfgtime.CTR_DATA_CHELTUIALA.ref].setValueFromSqlFormat(this.runtime.antetData.datac);
			        this.$refs[this.cfgtime.CTR_NR_DOCUMENT.ref].setValue(this.runtime.antetData.cNrDoc);
			        this.$refs[this.cfgtime.CTR_PARTNER_LIST.ref].setDataSelected( {id: this.runtime.antetData.id_part, caption: this.runtime.antetData.partner_name} );
			        this.$refs[this.cfgtime.CTR_DOCUMENT_TYPE.ref].setValue(this.runtime.antetData.id_tipd);
			        this.$refs[this.cfgtime.CTR_TIP_CHELTUIELI.ref].setValue(this.runtime.antetData.id_tipc);


		        }
	        },
            setModeForm: function (mode) {
                this.runtime.mode = mode;
	            let readOnly = true;

                if(this.runtime.mode == this.$constFROM.MODE_EDIT) {
	                readOnly = true;
	                this.$refs[this.cfgtime.REF_BUTTON_ADD_CHELT].disable(readOnly);
	                this.$refs[this.cfgtime.REF_BUTTON_REMOVE_CHELT].disable(false);
                }

                if(this.runtime.mode == this.$constFROM.MODE_NEW) {
	                readOnly = false;
	                this.$refs[this.cfgtime.REF_BUTTON_ADD_CHELT].disable(readOnly);
	                this.$refs[this.cfgtime.REF_BUTTON_REMOVE_CHELT].disable(true);
                }


                console.log(mode, readOnly);
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
        },
        data () {
            return {
            }
        }
    }

</script>

<style scoped></style>
