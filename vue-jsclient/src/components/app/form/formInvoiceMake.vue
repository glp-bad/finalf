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

    <validate-window ref="refYesNoNew"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoButtonNew"
    ></validate-window>

    <form-tab :ref = this.REF_FORM>
        <template v-slot:slotTitle>
        </template>
        <template v-slot:slotContent>

            <table class="ff-form-table">
                <tr>
                    <td class="label-left bold">
                        <label :for=this.cfgtime.INPUT_DATE.id>{{this.cfgtime.INPUT_DATE.caption}}</label></td>
                    <td class="control">
                        <my-datetime
                            :ref = this.cfgtime.INPUT_DATE.ref
                            :pConfig = this.cfgtime.INPUT_DATE
                        ></my-datetime>
                    </td>

                    <td class="label-left bold">
                        <label :for=this.cfgtime.INPUT_PARTNER.id>{{this.cfgtime.INPUT_PARTNER.caption}}</label></td>
                    <td class="control">
                        <my-dropdown-search :ref = this.cfgtime.INPUT_PARTNER.ref
                                            :pConfig = this.cfgtime.INPUT_PARTNER
                        ></my-dropdown-search>
                    </td>
                    <td class="control">
                        <my-dds
                            :pConfig = this.cfgtime.NOM_INVOCE_TYPE
                            :ref = this.cfgtime.NOM_INVOCE_TYPE.ref
                        ></my-dds>
                    </td>

                    <td class="control">
                        <my-inputField
                            :ref = this.cfgtime.INPUT_TVA.ref
                            :pConfig = this.cfgtime.INPUT_TVA
                        ></my-inputField>
                    </td>

                    <td class="control">
                        <div class="toolbar-icon-inline">
                            <div class="divButton">
                                &nbsp;&nbsp;
                                <my-button  :ref=this.cfgtime.REF_BUTTON_ADD_INVOICE @click="this.addNewInvoice" :heightButton=22 :buttonType=2 title="adauga factura" :style="this.cfgtime.ICON_ADD_INVOCE.colorStyle">
                                    <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.cfgtime.ICON_ADD_INVOCE) size="1x" />
                                </my-button>
                            </div>

                            <div class="divButton">
                                <my-button  :ref=this.cfgtime.REF_BUTTON_REMOVE_INVOICE @click="this.removeNewInvoice" :heightButton=22 :buttonType=2 title="sterg factura" :style="this.cfgtime.ICON_REMOVE_INVOICE.colorStyle">
                                    <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.cfgtime.ICON_REMOVE_INVOICE) size="1x" />
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
    import AlertWindow    from "@/components/base/AlertWindow.vue";
    import FormTab        from "@/components/base/FormTab.vue";
    import DropDownSearch from "@/components/base/DropDownSearch.vue";
    import DropDownSimple from "@/components/base/DropDownSimple.vue";
    import InputDateTime  from "@/components/base/InputDateTime.vue";
    import InputField     from "@/components/base/InputField.vue";
    import Button         from "@/components/base/Button";

    export default {
        components: {
            'validate-window': AlertWindow,
            'form-tab': FormTab,
            'my-dropdown-search': DropDownSearch,
            'my-dds': DropDownSimple,
            'my-datetime': InputDateTime,
            'my-inputField': InputField,
            'my-button': Button

        },
        name: "form-invoice-make",
        created() {
            this.REF_FORM = 'refForm';
            this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
	            message: [],
                postNewInvoices: { idPk: null, field: {}, sqlAction: null}
            };
            this.cfgtime = {
                INPUT_PARTNER: this.cfgDropDownPartner(),
                NOM_INVOCE_TYPE: this.cfgInvoiceType(),
                INPUT_DATE: this.cfgInvoiceDate(),
                INPUT_TVA: this.cfgTva(),
                ICON_ADD_INVOCE: this.$constComponent.ICON_PLUS_SQUARE("blue"),
                ICON_REMOVE_INVOICE: this.$constComponent.ICON_MINUS_SQUARE("red"),
                REF_BUTTON_ADD_INVOICE: 'refAddInvoice',
                REF_BUTTON_REMOVE_INVOICE: 'refRemoveInvoice',
                URL_NEW_INVOICE: this.$url.getUrl('insertInvoiceAntet')
            };
        },
        emits: ['emitNewRecord'],
        mounted () {
            this.$refs[this.cfgtime.INPUT_TVA.ref].setValue(19);
            this.setModeForm(this.$constFROM.MODE_NEW);
        },
        methods: {
            addNewInvoice: function() {
                if(this.validateNewInvoice()){
                    this.$refs.validateWindowRef.show();
                    return false;
                }

                this.$refs[this.REF_FORM].showModal(true);

                this.axios
                    .post(this.cfgtime.URL_NEW_INVOICE, this.runtime.postNewInvoices)
                    .then(response => {
                        if (response.data.succes){


                            //this.getDataPartener(this.post.idPk);
                            //this.$refs.infoWindowRef.setCaption("Succes");
                            //this.$refs.infoWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
                            //this.$refs.infoWindowRef.show();
                        }
                        else {
                            //this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
                            //this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
                            //this.$refs.validateWindowRef.show();
                        }

                    })
                    .catch(error => console.log(error))
                    .finally(() => {
                        this.$refs[this.REF_FORM].showModal(false);

                    });

                this.setModeForm(this.$constFROM.MODE_EDIT);
            },
            removeNewInvoice: function () {
                this.setModeForm(this.$constFROM.MODE_NEW);
            },
            emitYesNoButton: function() {
            },
            emitYesNoButtonNew: function() {
            },
            setModeForm: function (mode) {
                this.runtime.mode = mode;

                let readOnly = true;

                if(this.runtime.mode == this.$constFROM.MODE_EDIT) {
                    readOnly = true;
                    this.$refs[this.cfgtime.REF_BUTTON_ADD_INVOICE].disable(readOnly);
                    this.$refs[this.cfgtime.REF_BUTTON_REMOVE_INVOICE].disable(false);
                }

                if(this.runtime.mode == this.$constFROM.MODE_NEW) {
                    readOnly = false;
                    this.resetPostNewInvoice();
                    this.$refs[this.cfgtime.REF_BUTTON_ADD_INVOICE].disable(readOnly);
                    this.$refs[this.cfgtime.REF_BUTTON_REMOVE_INVOICE].disable(true);
                }

                this.$refs[this.cfgtime.INPUT_DATE.ref].setReadOnly(readOnly);
                this.$refs[this.cfgtime.INPUT_TVA.ref].setReadOnly(readOnly);
                this.$refs[this.cfgtime.NOM_INVOCE_TYPE.ref].setReadOnly(readOnly);
                this.$refs[this.cfgtime.INPUT_PARTNER.ref].setReadOnly(readOnly);

            },
            setPostNewInvoice: function (component, value){
                this.runtime.postNewInvoices['field'][component.name] = value;
            },
            resetPostNewInvoice: function (){
                this.runtime.postNewInvoices['field']={};
            },
            cfgDropDownPartner: function(){
                let cfg = this.$app.cfgSelectSearch('nomPartner', this.$url.getUrl('listPartener'), 450);
                cfg.setValidateFunction(this.validatePartner);
                cfg.setCaption("Partener");
                cfg.setMandatory(true);
                return cfg;
            },
            cfgInvoiceType: function(){
                let cfg = this.$app.cfgSelectSimple('nomInvoiceType', this.$url.getUrl('nomInvoiceType'), 150);
                cfg.setValidateFunction(this.validateInvoiceType);
                cfg.setCaption("Tip factura");
                cfg.setMandatory(true);
                cfg.setPlaceHolder('... (tip venit)');
                cfg.setDefaultValue({id: 1, text: 'venit profesional'});
                return cfg;
            },
            cfgInvoiceDate: function(){
                let cfg = this.$app.cfgInputDateTimeField("invoiceDate", 11);
                cfg.setValidateFunction(this.validateInvoiceDate);
                cfg.setCaption("Data factura");
                cfg.setMandatory(true);
                return cfg;
            },
            cfgTva: function(){
                let cfg = this.$app.cfgInputField("tva", 2);
                cfg.setValidateFunction(this.validateTVA);
                cfg.setCaption("TVA");
                cfg.setMandatory(true);
                cfg.setMaska("");
                return cfg;
            },
            validateNewInvoice: function (){
                let returnMessage = false;

                this.runtime.message = [];
                this.$check.validateForm(this.$refs);

                if( this.runtime.message.length>0 ){
                    this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
                    this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.runtime.message));
                    returnMessage = true;
                }
                return returnMessage;
            },
            validateInvoiceDate: function () {
                let control = this.cfgtime.INPUT_DATE;
                let value = this.$refs[control.ref].getValue();
                let splitDate = this.$refs[control.ref].getSplitValue();

                if(!this.$check.isExistDate(splitDate, true)){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Data este gresita!"));
                }

                this.setPostNewInvoice(control, value);
            },
            validatePartner: function (){
                let control = this.cfgtime.INPUT_PARTNER;
                let value = this.$refs[control.ref].getValue();
                let id = -1;

                if( this.$check.isUndef(value) || parseInt(value.id) < 1){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Trebuie sa alegi un partener"));
                }else{
                    id = value.id;
                }

                this.setPostNewInvoice(control, id);
            },
            validateInvoiceType: function () {
                let control = this.cfgtime.NOM_INVOCE_TYPE;
                let value = this.$refs[control.ref].getValue();

                let id = -1;

                if( this.$check.isUndef(value) || parseInt(value.id) < 1){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Trebuie sa alegi tipul de venit."));
                }else{
                    id = value.id;
                }
                this.setPostNewInvoice(control, id);
            },
            validateTVA: function () {
                let control = this.cfgtime.INPUT_TVA;
                let value = this.$refs[control.ref].getValue();

                if( this.$check.isUndef(value) || parseInt(value) < 1){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Cota de TVA este gresita!"));
                }
                this.setPostNewInvoice(control, value);
            }
        },
        data () {
            return {
            }
        }
    }

</script>

<style scoped></style>

