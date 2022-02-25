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
            ></my-list>

            <form>
                <table class="ff-form-table">
                    <tr>
                        <td class="control">
                            <check-box
                                    :pConfig = this.cfgtime.CHECK_MANUAL_NUMBER
                                    :ref= this.cfgtime.CHECK_MANUAL_NUMBER.ref
                            ></check-box>
                        </td>
                        <td class="label-left bold">
                            <label>{{this.cfgtime.CHECK_MANUAL_NUMBER.caption}}</label></td>
                        <td class="label-left bold">
                            <input-field
                                :ref = this.cfgtime.NR_DOCUMENT.ref
                                :pConfig = this.cfgtime.NR_DOCUMENT
                            ></input-field>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-left bold">
                            <label :for=this.cfgtime.DOCUMENT_DATA.id>{{this.cfgtime.DOCUMENT_DATA.caption}}</label></td>
                        <td class="control">
                            <my-datetime
                                :ref = this.cfgtime.DOCUMENT_DATA.ref
                                :pConfig = this.cfgtime.DOCUMENT_DATA
                            ></my-datetime>
                        </td>
                        <td class="control">
                            <my-dropdown-simple
                                :pConfig = this.cfgtime.DOCUMENT_TYPE
                                :ref = this.cfgtime.DOCUMENT_TYPE.ref
                            ></my-dropdown-simple>
                        </td>
                        <td class="label-left bold">
                            <label :for=this.cfgtime.AMOUNT_RECIVED.id>{{this.cfgtime.AMOUNT_RECIVED.caption}}</label></td>
                        <td class="control">
                            <input-field
                                :ref = this.cfgtime.AMOUNT_RECIVED.ref
                                :pConfig = this.cfgtime.AMOUNT_RECIVED
                            ></input-field>
                        </td>

                        <td class="control">
                            <my-radio-button
                                :ref = this.cfgtime.TIP_INCASARE.ref
                                :pConfig = this.cfgtime.TIP_INCASARE
                                @emitClickTipIncasare = 'emitClickTipIncasare'
                            ></my-radio-button>
                        </td>
                    </tr>
                </table>

            </form>



        </template>
        <template v-slot:slotButton>

        </template>

    </form-tab>
</template>

<script>
    import AlertWindow   from "@/components/base/AlertWindow.vue";
    import FormTab       from "@/components/base/FormTab.vue";
    import Lista         from "@/components/base/Lista";
    import InputField    from "@/components/base/InputField.vue";
    import CheckBox      from "@/components/base/CheckBox.vue";
    import InputDateTime from "@/components/base/InputDateTime.vue";
    import DropDownSimple from "@/components/base/DropDownSimple.vue";
    import RadioButton    from "@/components/base/RadioButton.vue";


    export default {
        components: {
            'validate-window': AlertWindow,
            'form-tab': FormTab,
            'my-list': Lista,
	        'input-field': InputField,
	        'check-box': CheckBox,
	        'my-datetime': InputDateTime,
	        'my-dropdown-simple': DropDownSimple,
            'my-radio-button': RadioButton
        },
        name: "form-incasez",
        created() {
            this.REF_FORM = 'refFormIncasez';
            this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
	            message: []
            };
            this.cfgtime = {
	            TIP_INCASARE: {
	            	ref: 'refTipIncasare',
		            alignment: this.$constRadioButton.ALIGNMENT_H,
                    name: 'tipIncasare',
                    emit: 'emitClickTipIncasare',
                    buttons:[
                        {id: 1, value: '1p', caption: 'Numerar', check: false, disableOption: false },
	                    {id: 2, value: '2p', caption: 'Banca', check: false, disableOption: false }

                    ]
                },
	            NR_DOCUMENT: this.cfgNrDoc(),
	            AMOUNT_RECIVED: this.cfgAmountRecived(),
	            CHECK_MANUAL_NUMBER: this.cfgCheckManualNumber(),
	            DOCUMENT_DATA: this.cfgDocumentDate(),
                DOCUMENT_TYPE: this.cfgDocumentType(),
                CFG_INVOICE_LIST : {
                    ref: 'refDetailList',
                    header: [
	                    this.$constList.getHeader(1, 'Tip factura',     70, 'tip_factura',       this.$constList.HEADER.CAPTION_TYPE_FIELD ),
                        this.$constList.getHeader(2, 'Nr. factura',     70, 'nr_factura',        this.$constList.HEADER.CAPTION_TYPE_FIELD ),
	                    this.$constList.getHeader(3, 'Data factura',    70, 'data_f_view',            this.$constList.HEADER.CAPTION_TYPE_FIELD ),
	                    this.$constList.getHeader(4, 'Client',          70, 'client_name',       this.$constList.HEADER.CAPTION_TYPE_FIELD ),
	                    this.$constList.getHeader(5, 'Org.',            70, 'client_tip_firma',  this.$constList.HEADER.CAPTION_TYPE_FIELD ),
	                    this.$constList.getHeader(6, 'CUI',             70, 'client_cod_fiscal', this.$constList.HEADER.CAPTION_TYPE_FIELD ),
	                    this.$constList.getHeader(7, 'Suma factura',    70, 'total_factura',     this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT),
	                    this.$constList.getHeader(8, 'Suma incasata',   70, 'total_incasat',     this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT),
	                    this.$constList.getHeader(9, '... de incasat',  70, 'rest_de_incasat',   this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT)

                        // this.$constList.getHeader(5, 'Action', 100, 'null', this.$constList.HEADER.CAPTION_TYPE_ACTION)
                    ],
                    recordActionButon: [
                        // this.$constList.getActionButton(4, 'sterg articol', 'emitStergArticol', this.$constGrid.ICON_DELETE, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null)
                        // this.$constList.getActionButton(5, 'adresa implicita', 'emitAdresaImplicita', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('ro', false)),   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
                        // this.$constList.getActionButton(6, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00'))
                    ],
                    cfg: {  urlData: 'listaUnpaidInvoices', loadOnCreate: true,
                            filedNameForCheckBox: 'activ', emitListRowSelection: 'emitListRowSelection',
                            heightList: 300
                    }
                },
            };
        },
        emits: ['emitNewRecord'],
        mounted () {
        },
        methods: {
	        emitClickTipIncasare: function(event){
	            console.log(this.$refs[this.cfgtime.TIP_INCASARE.ref].getValue());
            },
	        emitYesNo: function(){

            },
	        cfgNrDoc: function(){
		        let cfg = this.$app.cfgInputField("nrDoc", null, 120);
		        cfg.setValidate(2,100);
		        cfg.setValidateFunction(this.validateNrDoc);
		        cfg.setCaption("Numar document manual");
		        cfg.setMandatory(true);
		        cfg.setMaska("");
		        return cfg;
	        },
	        cfgCheckManualNumber: function (){
		        let cfg = this.$app.cfgCheckBox('manualNumber', false);
		        cfg.setCaption('Nr. document manual');
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
		        cfg.setDefaultValue({id: 1, text: 'venit profesional'});
		        return cfg;
	        },
	        cfgAmountRecived: function(){
		        let cfg = this.$app.cfgInputField("amountRecived", null, 120);
		        cfg.setValidateFunction(this.validateAmountRecived);
		        cfg.setCaption("Suma incasata");
		        cfg.setMandatory(true);
		        cfg.setMaska("");
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



