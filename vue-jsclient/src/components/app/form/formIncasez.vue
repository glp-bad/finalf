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
                     :cWidth=400
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNo"
    ></validate-window>

    <form-tab :ref = this.REF_FORM>
        <template v-slot:slotTitle>
            <!-- <div class="antet"> <div class="title">... test</div> </div> -->
        </template>
        <template v-slot:slotContent>
            <my-list
                :ref = this.cfgtime.CFG_INVOICE_LIST.ref
                :pConfig = this.cfgtime.CFG_INVOICE_LIST
                @emitListRowSelection="emitListRowSelection"
                @emitFinallyCustomResponse="emitListResumData"
            ></my-list>

            <br>
            <div class="form-rezumat-right">
                <table class="ff-form-table">
                    <tr>

                        <td class="label-left bold">
                            <label>Facturi emise:</label></td>
                        <td class="control">
                            {{this.dataRezumat.nr_facturi}}
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            &nbsp; &nbsp; &nbsp; &nbsp;
                        </td>
                        <td class="label-left bold">
                            <label>Total facturat:</label></td>
                        <td class="control">
                            {{this.dataRezumat.totalFacturat}}
                        </td>
                        <td class="label-left bold">
                            <label>&nbsp;&nbsp;&nbsp;Total incasat:</label></td>
                        <td class="control">
                            {{this.dataRezumat.totalIncasat}}
                        </td>
                        <td class="label-left bold">
                            <label>&nbsp;&nbsp;&nbsp;Ramas de incasat:</label></td>
                        <td class="control">
                            {{this.dataRezumat.totalRamas}}
                            &nbsp; &nbsp; &nbsp; &nbsp;
                        </td>
                    </tr>
                </table>
            </div>

            <br>
            <br>
                <table class="ff-form-table">
                    <tr>
                        <td class="label-left bold" colspan="1">
                            <div :ref=this.cfgtime.REF_FIELD_NR_FACTURA_SELECTATA>
                                <label>{{this.numar_factura}}</label>
                            </div>
                        </td>
                        <td class="label-left bold" colspan="3">
                            <check-box
                                :pConfig = this.cfgtime.CHECK_MANUAL_NUMBER
                                :ref= this.cfgtime.CHECK_MANUAL_NUMBER.ref
                                @emitCheckDocumentManual = "emitCheckDocumentManual"
                            ></check-box>
                            <label>{{this.cfgtime.CHECK_MANUAL_NUMBER.caption}}</label>
                            &nbsp; &nbsp;
                            <input-field
                                :ref = this.cfgtime.NR_DOCUMENT.ref
                                :pConfig = this.cfgtime.NR_DOCUMENT
                            ></input-field>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-left bold" colspan="1">

                            <label :for=this.cfgtime.DOCUMENT_DATA.id>{{this.cfgtime.DOCUMENT_DATA.caption}}</label>
                            &nbsp;
                            <my-datetime
                                :ref = this.cfgtime.DOCUMENT_DATA.ref
                                :pConfig = this.cfgtime.DOCUMENT_DATA
                            ></my-datetime>
                         </td>
                        <td class="label-left bold" colspan="2">
                            <my-dropdown-simple
                                :pConfig = this.cfgtime.DOCUMENT_TYPE
                                :ref = this.cfgtime.DOCUMENT_TYPE.ref
                            ></my-dropdown-simple>
                        </td>
                        <td class="label-right bold">
                            &nbsp;&nbsp;
                            <label :for=this.cfgtime.AMOUNT_RECIVED.id>{{this.cfgtime.AMOUNT_RECIVED.caption}}</label></td>
                        <td class="control">
                            <input-field
                                :ref = this.cfgtime.AMOUNT_RECIVED.ref
                                :pConfig = this.cfgtime.AMOUNT_RECIVED
                            ></input-field>
                            &nbsp; &nbsp;
                        </td>

                        <td class="control">
                            <my-radio-button
                                :ref = this.cfgtime.TIP_INCASARE.ref
                                :pConfig = this.cfgtime.TIP_INCASARE
                                @emitClickTipIncasare = 'emitClickTipIncasare'
                            ></my-radio-button>
                        </td>

                        <td class="control">
                            &nbsp; &nbsp; <my-button  :ref=this.cfgtime.REF_BUTTON_SAVE @click="this.saveData" :heightButton=22 :buttonType=0 title="salvez incasarea in baza de date">Salvez incasare</my-button>
                        </td>
                    </tr>
                </table>

        </template>

        <template v-slot:slotButton></template>
    </form-tab>

</template>

<script>
    import AlertWindow      from "@/components/base/AlertWindow.vue";
    import FormTab          from "@/components/base/FormTab.vue";
    import Lista            from "@/components/base/Lista";
    import InputField       from "@/components/base/InputField.vue";
    import CheckBox         from "@/components/base/CheckBox.vue";
    import InputDateTime    from "@/components/base/InputDateTime.vue";
    import DropDownSimple   from "@/components/base/DropDownSimple.vue";
    import RadioButton      from "@/components/base/RadioButton.vue";
    import Button           from "@/components/base/Button";



    export default {
        components: {
            'validate-window': AlertWindow,
            'form-tab': FormTab,
            'my-list': Lista,
	        'input-field': InputField,
	        'check-box': CheckBox,
	        'my-datetime': InputDateTime,
	        'my-dropdown-simple': DropDownSimple,
            'my-radio-button': RadioButton,
            'my-button': Button
        },
        name: "form-incasez",
        created() {
            this.REF_FORM = 'refFormIncasez';
            this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
	            message: [],
                postRecordData:{}
            };
            this.cfgtime = {
                REF_BUTTON_SAVE: 'refButtonSave',
                REF_FIELD_NR_FACTURA_SELECTATA: 'refNrFactura',
	            TIP_INCASARE: {
                    id: 'refTipIncasare',
	            	ref: 'refTipIncasare',
                    caption: 'Tip incasare',
		            alignment: this.$constRadioButton.ALIGNMENT_H,
                    name: 'tipIncasare',
                    emit: 'emitClickTipIncasare',
                    buttons:[
                        {id: 1, value: '1', caption: 'Numerar', check: false, disableOption: false },
	                    {id: 2, value: '2', caption: 'Banca', check: false, disableOption: false }

                    ]
                },
	            NR_DOCUMENT: this.cfgNrDoc(),
	            AMOUNT_RECIVED: this.cfgAmountRecived(),
	            CHECK_MANUAL_NUMBER: this.cfgCheckManualNumber(),
	            DOCUMENT_DATA: this.cfgDocumentDate(),
                DOCUMENT_TYPE: this.cfgDocumentType(),
                URL_SAVE_INCASARE: this.$url.getUrl('saveIncoming'),
                CFG_INVOICE_LIST : {
                    ref: 'refDetailList',
                    header: [
	                    this.$constList.getHeader(1, 'Tip factura',     110, 'tip_factura',       this.$constList.HEADER.CAPTION_TYPE_FIELD ),
                        this.$constList.getHeader(2, 'Nr. factura',     110, 'nr_factura',        this.$constList.HEADER.CAPTION_TYPE_FIELD , this.$constComponent.ALIGN_TEXT_CENTER ),
	                    this.$constList.getHeader(3, 'Data factura',    90, 'data_f_view',       this.$constList.HEADER.CAPTION_TYPE_FIELD , this.$constComponent.ALIGN_TEXT_CENTER ),
	                    this.$constList.getHeader(4, 'Client',          490, 'client_name',       this.$constList.HEADER.CAPTION_TYPE_FIELD ),
	                    this.$constList.getHeader(5, 'Org.',            50, 'client_tip_firma',  this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER  ),
	                    this.$constList.getHeader(6, 'CUI',             70, 'client_cod_fiscal', this.$constList.HEADER.CAPTION_TYPE_FIELD ),
	                    this.$constList.getHeader(7, 'Suma factura',    90, 'total_factura',     this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT),
	                    this.$constList.getHeader(8, 'Suma incasata',   90, 'total_incasat',     this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT),
	                    this.$constList.getHeader(9, '... de incasat',  90, 'rest_de_incasat',   this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT)

                        // this.$constList.getHeader(5, 'Action', 100, 'null', this.$constList.HEADER.CAPTION_TYPE_ACTION)
                    ],
                    recordActionButon: [
                        // this.$constList.getActionButton(4, 'sterg articol', 'emitStergArticol', this.$constGrid.ICON_DELETE, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null)
                        // this.$constList.getActionButton(5, 'adresa implicita', 'emitAdresaImplicita', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('ro', false)),   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
                        // this.$constList.getActionButton(6, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00'))
                    ],
                    cfg: {  urlData: 'listaUnpaidInvoices', loadOnCreate: false,
                            filedNameForCheckBox: 'activ',
                            headerLenghtActivate: true,                         // tine cont de lungimea coloanelor setate in header
                            emitListRowSelection: 'emitListRowSelection',
                            heightList: 310
                    }
                },
            };
        },
        emits: ['emitNewRecord'],
        mounted () {
            this.privateResetPost();

            this.$refs[this.cfgtime.REF_BUTTON_SAVE].disable(true);
            this.$refs[this.cfgtime.NR_DOCUMENT.ref].setReadOnly(true);
            this.$refs[this.cfgtime.REF_FIELD_NR_FACTURA_SELECTATA].style.minWidth = '150px';
            this.$refs[this.cfgtime.REF_FIELD_NR_FACTURA_SELECTATA].closest('td').style.backgroundColor = '#d9d9d9';

            this.refreshListaFacturiNeincasate();
        },
        methods: {
            saveData: function (){
                if(this.validateForm()){
                    this.$refs.validateWindowRef.show();
                    return false;
                }

                if(!this.runtime.sendDataToServer){
                    this.$refs.refYesNo.setCaption("Incasez");
                    this.$refs.refYesNo.setMessage('Incasez factura selectata? Suma este corecta ?');
                    this.$refs.refYesNo.show();
                }

                if(this.runtime.sendDataToServer){
                    this.runtime.sendDataToServer = false;

                    this.$refs[this.REF_FORM].showModal(true);

                    this.axios
                        .post(this.cfgtime.URL_SAVE_INCASARE , this.runtime.postRecordData)
                        .then(response => {
                            if (response.data.succes){
                            }
                            else {
                                this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
                                this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
                                this.$refs.validateWindowRef.show();
                            }

                        })
                        .catch(error => console.log(error))
                        .finally(() => {
                            this.refreshListaFacturiNeincasate();
                            this.$refs[this.REF_FORM].showModal(false);
                        });

                }
            },
            refreshListaFacturiNeincasate: function(){
                this.privateResetPost();
                this.$refs[this.cfgtime.REF_BUTTON_SAVE].disable(true);
                this.numar_factura = '...';
                this.$refs[this.cfgtime.AMOUNT_RECIVED.ref].setValue(0);

                this.$refs[this.cfgtime.CFG_INVOICE_LIST.ref].showList();
            },
            emitListRowSelection: function(dataSelect){
                this.privateResetPost();

                this.$refs[this.cfgtime.REF_BUTTON_SAVE].disable(false);
                let tr = dataSelect.closest('tr');

                for(let i=0; i < tr.children.length; i++){
                    if(tr.children[i].getAttribute('field') == 'nr_factura'){
                        this.numar_factura = tr.children[i].firstChild.innerHTML;
                    }
                    if(tr.children[i].getAttribute('field') == 'rest_de_incasat'){
                        let suma = tr.children[i].firstChild.innerHTML;
                        this.$refs[this.cfgtime.AMOUNT_RECIVED.ref].setValue(suma);
                        this.runtime.postRecordData.rest_de_incasat = suma;
                    }
                }
                this.runtime.postRecordData.id_factura = tr.getAttribute('idpk');
            },
            emitListResumData: function (dataResume){
                this.dataRezumat.totalFacturat = dataResume.total_facturat;
                this.dataRezumat.totalIncasat= dataResume.total_incasari;
                this.dataRezumat.totalRamas= dataResume.total_ramas_de_incasat;
                this.dataRezumat.nr_facturi = dataResume.nr_facturi;


            },
            emitCheckDocumentManual: function (event){
                this.$refs[this.cfgtime.NR_DOCUMENT.ref].setReadOnly(!event.checked);

                if(event.checked){
                    this.$refs[this.cfgtime.NR_DOCUMENT.ref].setFocus();
                }else{
                    this.$refs[this.cfgtime.NR_DOCUMENT.ref].setValue('');
                }


            },
	        emitClickTipIncasare: function(event){
	            // console.log(this.$refs[this.cfgtime.TIP_INCASARE.ref].getValue());
            },
	        emitYesNo: function(yes){
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
                    this.saveData();
                }else{
                    this.runtime.sendDataToServer = false;
                }

            },
            validateForm: function(){
                let returnMessage = false;
                this.runtime.message = [];
                this.$check.validateForm(this.$refs);

                if( this.runtime.message.length>0 ){
                    this.$refs.validateWindowRef.setCaption("Factura nu poate fi incasata");
                    this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.runtime.message));
                    returnMessage = true;
                }
                return returnMessage;
            },
            validateManualNumber: function () {
                // include si validateDocumentDate
                let objNrDoc = this.cfgtime.NR_DOCUMENT;
                let objCheck = this.cfgtime.CHECK_MANUAL_NUMBER;
                let checkManualNUmber = this.$refs[objCheck.ref].getValue();
                let valueManualNumber = this.$refs[objNrDoc.ref].getValue();

                if(checkManualNUmber){
                    if(!this.$check.lenghtMinMax(valueManualNumber, objNrDoc.minLength, objNrDoc.maxLength)){
                        this.runtime.message.push(this.$app.getFormMessageClass(objNrDoc.id, objNrDoc.caption,
                            'trebuie sa aiba minim ' + objNrDoc.minLength + " si maxim " + objNrDoc.maxLength + " caractere"));
                    }
                }

                this.privateSetPost(objCheck, checkManualNUmber);
                this.privateSetPost(objNrDoc, valueManualNumber);
            },
            validateDocumentDate : function (){
                let control = this.cfgtime.DOCUMENT_DATA;
                let value = this.$refs[control.ref].getValue();
                let splitDate = this.$refs[control.ref].getSplitValue();

                if(!this.$check.isExistDate(splitDate, true)){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Data este gresita!"));
                }

                this.privateSetPost(control, value);
            },
            validateInvoiceType: function () {
                let control = this.cfgtime.DOCUMENT_TYPE;
                let value = this.$refs[control.ref].getValue();
                let id = -1;

                if (this.$check.isUndef(value) || parseInt(value.id) < 1) {
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Trebuie sa alegi tipul de document cu care incasezi."));
                } else {
                    id = value.id;
                }
                this.privateSetPost(control, id);
            },
            validateAmountRecived: function (){
                let control = this.cfgtime.AMOUNT_RECIVED;
                let value = parseFloat(this.$refs[control.ref].getValue());

                if(value <= 0){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Suma incasata trebuie sa fie mai mare ca zero"));
                }else{
                    if(value > parseFloat(this.runtime.postRecordData.rest_de_incasat)){
                        this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                            "Suma incasata nu poate fi mai mare ca suma ramasa de incasat! "));
                    }
                }


                let control01 = this.cfgtime.TIP_INCASARE;
                let valueTipincasare = this.$refs[control01.ref].getValue();

                if(this.$check.isUndef(valueTipincasare)){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control01.caption,
                        "Trebuie sa alegi tipul de incasare"));
                }

               this.privateSetPost(control, value);
               this.privateSetPost(control01, valueTipincasare);

            },
	        cfgNrDoc: function(){
		        let cfg = this.$app.cfgInputField("nrDoc", null, 120);
		        cfg.setValidate(2,15);
		        cfg.setValidateFunction(this.validateNrDoc);
		        cfg.setCaption("Numar document manual");
		        cfg.setMandatory(true);
		        cfg.setMaska("");
		        return cfg;
	        },
	        cfgCheckManualNumber: function (){
		        let cfg = this.$app.cfgCheckBox('manualNumber', false);
		        cfg.setCaption('Nr. document manual');
		        cfg.setEmit('emitCheckDocumentManual');
		        cfg.setValidateFunction(this.validateManualNumber);
		        return cfg;
	        },
	        cfgDocumentDate: function(){
		        let cfg = this.$app.cfgInputDateTimeField("invoiceDate", 11, 80);
		        cfg.setValidateFunction(this.validateDocumentDate);
		        cfg.setCaption("Data");
		        cfg.setMandatory(true);
		        return cfg;
	        },
	        cfgDocumentType: function(){
		        let cfg = this.$app.cfgSelectSimple('nomDocumentType', this.$url.getUrl('nomDocumentTipe'), 200);
		        cfg.setValidateFunction(this.validateInvoiceType);
		        cfg.setCaption("Tip document");
		        cfg.setMandatory(true);
		        cfg.setPlaceHolder('... (tip document)');
		        cfg.setDefaultValue({id: 0, text: 'venit profesional'});
		        return cfg;
	        },
	        cfgAmountRecived: function(){
		        let cfg = this.$app.cfgInputField("amountRecived", null, 120);
		        cfg.setValidateFunction(this.validateAmountRecived);
		        cfg.setCaption("Suma incasata");
		        cfg.setMandatory(true);
		        cfg.setMaska("");
		        return cfg;
	        },
            privateSetPost: function (component, value){
                this.runtime.postRecordData['field'][component.name] = value;
            },
            privateResetPost: function () {
                this.runtime.postRecordData = {
                    id_factura: 0,
                        rest_de_incasat: 0, // for check sum when send to server
                        field: {},
                    sqlAction: null
                }
            }
        },
        data () {
            return {
                dataRezumat: {totalFacturat: 0.00, totalIncasat: 0.00,  totalRamas: 0.00, nr_facturi: 0},
                numar_factura: '...'
            }
        }
    }

</script>

<style scoped></style>



