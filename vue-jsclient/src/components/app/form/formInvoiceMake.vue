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

    <validate-window ref="refYesNoDeleteAntet"
                     :cWidth=400
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoDeleteAntet"
    ></validate-window>

    <validate-window ref="refYesNoNew"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoButtonNew"
    ></validate-window>

    <form-tab :ref = this.REF_FORM>
        <template v-slot:slotTitle>
            <div class="antet">
                <div class="title">{{this.invoiceNumber}}</div>
            </div>
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
                                <my-button  :ref=this.cfgtime.REF_BUTTON_REMOVE_INVOICE @click="this.deleteAntetInvoice" :heightButton=22 :buttonType=2 title="sterg factura" :style="this.cfgtime.ICON_REMOVE_INVOICE.colorStyle">
                                    <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.cfgtime.ICON_REMOVE_INVOICE) size="1x" />
                                </my-button>
                            </div>

                        </div>
                    </td>

                </tr>

            </table>
            &nbsp;&nbsp;
            <table class="ff-form-table">
                <tr>
                    <td class="label-left bold">
                        <label :for=this.cfgtime.NOM_INVOICE_TEMPLATE.id>{{this.cfgtime.NOM_INVOICE_TEMPLATE.caption}}</label></td>
                    <td class="control" >
                        <my-dds
                            :pConfig = this.cfgtime.NOM_INVOICE_TEMPLATE
                            :ref = this.cfgtime.NOM_INVOICE_TEMPLATE.ref
                            @emitChange = "emitTemplate"
                        ></my-dds>
                    </td>
                </tr>
                &nbsp;&nbsp;
                <tr>
                    <td class="label-left bold">
                        <label :for=this.cfgtime.INPUT_TEXT_FACTURA.id>{{this.cfgtime.INPUT_TEXT_FACTURA.caption}}</label></td>
                    <td class="control">
                        <my-inputField
                            :ref = this.cfgtime.INPUT_TEXT_FACTURA.ref
                            :pConfig = this.cfgtime.INPUT_TEXT_FACTURA
                        ></my-inputField>
                    </td>
                    <td class="label-left bold">
                        <label :for=this.cfgtime.INPUT_SUMA.id>{{this.cfgtime.INPUT_SUMA.caption}}</label></td>
                    <td class="control">
                        <my-inputField
                            :ref = this.cfgtime.INPUT_SUMA.ref
                            :pConfig = this.cfgtime.INPUT_SUMA
                        ></my-inputField>
                        &nbsp;&nbsp;&nbsp;
                    </td>
                    <td class="control">
                        <div class="buttons">
                            <my-button :ref=this.cfgtime.REF_BUTTON_ADD_ITEM @click="this.addArticol" :heightButton=22 :buttonType=0 title="adaug articol in factura">Adaug</my-button>
                        </div>
                    </td>
                </tr>

            </table>

            <table class="ff-form-table">

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
                postNewInvoices: { idPk: null, field: {}, sqlAction: null},
                postNewItem: { idPk: null, idInvoice: null, field: {}, sqlAction: null},
                postDeleteAntetInvoices: { idPk: null},
                antetData: null
            };
            this.cfgtime = {
                INPUT_PARTNER:              this.cfgDropDownPartner(),
                NOM_INVOCE_TYPE:            this.cfgInvoiceType(),
                NOM_INVOICE_TEMPLATE:       this.cfgInvoiceTemplate(),
                INPUT_DATE:                 this.cfgInvoiceDate(),
                INPUT_TVA:                  this.cfgTva(),
                INPUT_TEXT_FACTURA:         this.cfgTextFactura(),
                INPUT_SUMA:                 this.cfgSuma(),
                ICON_ADD_INVOCE:            this.$constComponent.ICON_PLUS_SQUARE("blue"),
                ICON_REMOVE_INVOICE:        this.$constComponent.ICON_MINUS_SQUARE("red"),
                REF_BUTTON_ADD_INVOICE:     'refAddInvoice',
                REF_BUTTON_REMOVE_INVOICE:  'refRemoveInvoice',
                REF_BUTTON_ADD_ITEM:        'refAddItem',
                URL_NEW_INVOICE:            this.$url.getUrl('insertInvoiceAntet'),
                URL_CHECK_WORKING_INVOICE:  this.$url.getUrl('checkWorkingInvoice'),
                URL_DELETE_ANTET_INVOICE:   this.$url.getUrl('deleteInvoiceAntet'),
                URL_INSERT_INVOICE_ARTICOL: this.$url.getUrl('insertInvoiceArticol'),
                TVA: 19
            };
        },
        emits: ['emitNewRecord'],
        mounted () {
            this.$refs[this.cfgtime.INPUT_TVA.ref].setValue(this.cfgtime.TVA);
        },
        methods: {
            fillAFormAntet: function (){
                if(this.$check.isUndef(this.runtime.antetData)){
                    this.setModeForm(this.$constFROM.MODE_NEW);
                    this.invoiceNumber= 'XXXX 00000000';

                    this.$refs[this.cfgtime.INPUT_PARTNER.ref].resetDataSelected();
                    this.$refs[this.cfgtime.INPUT_PARTNER.ref].clearWordSearch();

                    this.$refs[this.cfgtime.NOM_INVOCE_TYPE.ref].setValue( this.cfgtime.NOM_INVOCE_TYPE.getDefaultValue().id);

                    this.$refs[this.cfgtime.INPUT_TVA.ref].setValue(this.cfgtime.TVA);
                }else{
                    this.setModeForm(this.$constFROM.MODE_EDIT);
                    this.$refs[this.cfgtime.INPUT_DATE.ref].setValueFromSqlFormat(this.runtime.antetData.data_f);
                    this.$refs[this.cfgtime.INPUT_PARTNER.ref].setDataSelected( {id: this.runtime.antetData.id_part, caption: this.runtime.antetData.cPartener} );
                    this.$refs[this.cfgtime.NOM_INVOCE_TYPE.ref].setValue(this.runtime.antetData.id_tipfactura);
                    this.$refs[this.cfgtime.INPUT_TVA.ref].setValue(this.runtime.antetData.nProcTva);

                    this.invoiceNumber = this.runtime.antetData.cNr;
                }

                 console.log(this.runtime.antetData);

            },
            addArticol: function (){
                if(this.validateInvoiceItem()){
                    this.$refs.validateWindowRef.show();
                    return false;
                }

                this.axios
                    .post(this.cfgtime.URL_INSERT_INVOICE_ARTICOL, this.runtime.postNewItem)
                    .then(response => {
                        if (response.data.succes) {
                            if(response.data.records.length > 0){
                            }else{
                            }
                        }
                        else {

                        }
                    })
                    .catch(error => console.log(error))
                    .finally(() => {
                        this.$refs[this.REF_FORM].showModal(false);
                    });

                console.log(this.runtime.postNewItem);
            },
            deleteAntetInvoice: function() {

                if(!this.runtime.sendDataToServer){
                    this.$refs.refYesNoDeleteAntet.setCaption("Sterg factura?");
                    this.$refs.refYesNoDeleteAntet.setMessage("Numarul de factura va fi pastrat si va fi folosit pentru urmatoarea factura.");
                    this.$refs.refYesNoDeleteAntet.show();
                }

                if(this.runtime.sendDataToServer){
                    this.runtime.sendDataToServer = false;
                    this.runtime.postDeleteAntetInvoices.idPk = this.runtime.antetData.id;

                    this.$refs[this.REF_FORM].showModal(true);

                    this.axios
                        .post(this.cfgtime.URL_DELETE_ANTET_INVOICE, this.runtime.postDeleteAntetInvoices)
                        .then(response => {
                            if (response.data.succes){
                            }
                            else {
                                this.$refs.validateWindowRef.setCaption("Nu se poate sterge factura");
                                this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
                                this.$refs.validateWindowRef.show();
                            }

                        })
                        .catch(error => console.log(error))
                        .finally(() => {
                            this.checkWorkingInvoice();
                            this.$refs[this.REF_FORM].showModal(false);
                        });

                }
            },
            checkWorkingInvoice: function() {
                this.$refs[this.REF_FORM].showModal(true);
                this.axios
                    .post(this.cfgtime.URL_CHECK_WORKING_INVOICE)
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
                        this.$refs[this.REF_FORM].showModal(false);
                    });
            },
            addNewInvoice: function() {
                if(this.validateNewInvoice()){
                    this.$refs.validateWindowRef.show();
                    return false;
                }

                this.$refs[this.REF_FORM].showModal(true);


                // console.log(this.runtime.postNewInvoices);

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
                            this.$refs.validateWindowRef.setCaption("Antetul nu poate fi inregistrat");
                            this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
                            this.$refs.validateWindowRef.show();
                        }

                    })
                    .catch(error => console.log(error))
                    .finally(() => {
                        this.checkWorkingInvoice();
                        this.$refs[this.REF_FORM].showModal(false);

                    });

                this.setModeForm(this.$constFROM.MODE_EDIT);
            },
            emitTemplate: function (data){
                this.$refs[this.cfgtime.INPUT_TEXT_FACTURA.ref].setValue(data.text);
            },
            emitYesNoDeleteAntet: function(yes) {
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
                    this.deleteAntetInvoice();
                }else{
                    this.runtime.sendDataToServer = false;
                }
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
                    this.$refs[this.cfgtime.REF_BUTTON_ADD_ITEM].disable(false);
                }

                if(this.runtime.mode == this.$constFROM.MODE_NEW) {
                    readOnly = false;
                    this.resetPostNewInvoice();
                    this.$refs[this.cfgtime.REF_BUTTON_ADD_INVOICE].disable(readOnly);
                    this.$refs[this.cfgtime.REF_BUTTON_REMOVE_INVOICE].disable(true);
                    this.$refs[this.cfgtime.REF_BUTTON_ADD_ITEM].disable(true);
                }

                this.$refs[this.cfgtime.INPUT_DATE.ref].setReadOnly(readOnly);
                this.$refs[this.cfgtime.INPUT_TVA.ref].setReadOnly(readOnly);
                this.$refs[this.cfgtime.NOM_INVOCE_TYPE.ref].setReadOnly(readOnly);
                this.$refs[this.cfgtime.INPUT_PARTNER.ref].setReadOnly(readOnly);

            },
            setPostNewInvoice: function (component, value){
                this.runtime.postNewInvoices['field'][component.name] = value;
            },
            setPostNewItem: function (component, value){
                this.runtime.postNewItem['field'][component.name] = value;
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
            cfgInvoiceTemplate: function(){
                let cfg = this.$app.cfgSelectSimple('nomInvoiceTemplate', this.$url.getUrl('nomInvoiceTemplate'), 400);
                // cfg.setValidateFunction(this.validateInvoiceType);
                cfg.setCaption("Template");
                //cfg.setMandatory(true);
                cfg.setPlaceHolder('... template');
                // cfg.setDefaultValue({id: 1, text: 'venit profesional'});
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
            cfgTextFactura: function(){
                let cfg = this.$app.cfgInputField("articolFactura", 110);
                cfg.setValidate(3,250);
                cfg.setValidateFunction(this.validateTextFactura);
                cfg.setCaption("Articol factura");
                cfg.setMandatory(true);
                cfg.setMaska("");
                return cfg;
            },
            cfgSuma: function (){
                let cfg = this.$app.cfgInputField("sumaArticol", 10);
                // cfg.setValidate(3,250);
                cfg.setValidateFunction(this.validateSuma);
                cfg.setCaption("Suma (fara TVA)");
                cfg.setMandatory(true);
                cfg.setMaska("");
                cfg.setDefaultValue('0.00');
                return cfg;
            },
            validateInvoiceItem: function () {
                let returnMessage = false;
                this.runtime.message = [];
                let validateArray = [this.$refs[this.cfgtime.INPUT_SUMA.ref], this.$refs[this.cfgtime.INPUT_TEXT_FACTURA.ref]];

                this.runtime.postNewItem.idInvoice = this.runtime.antetData.id;

                this.$check.validateForm(validateArray);

                if( this.runtime.message.length>0 ){
                    this.$refs.validateWindowRef.setCaption("Articolul nu poate fi inregistrat");
                    this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.runtime.message));
                    returnMessage = true;
                }
                return returnMessage;

            },
            validateNewInvoice: function (){
                let returnMessage = false;
                this.runtime.message = [];
                let validateArray = [this.$refs[this.cfgtime.INPUT_DATE.ref], this.$refs[this.cfgtime.INPUT_PARTNER.ref], this.$refs[this.cfgtime.NOM_INVOCE_TYPE.ref], this.$refs[this.cfgtime.INPUT_TVA.ref]];

                this.$check.validateForm(validateArray);

                if( this.runtime.message.length>0 ){
                    this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
                    this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.runtime.message));
                    returnMessage = true;
                }
                return returnMessage;
            },
            validateSuma: function (){
                let control = this.cfgtime.INPUT_SUMA;
                let value = this.$refs[control.ref].getValue();
                value = parseFloat(value);

                if(isNaN(value)){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        'Suma articolului este gresita!'));
                }

                this.setPostNewItem(control, value);

            },
            validateTextFactura: function (){
                let control = this.cfgtime.INPUT_TEXT_FACTURA;

                let value = this.$refs[control.ref].getValue();
                if(!this.$check.lenghtMinMax(value, control.minLength, control.maxLength)){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        'trebuie sa aiba minim ' + control.minLength + " si maxim " + control.maxLength + " caractere"));
                }

                this.setPostNewItem(control, value);
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

                if( this.$check.isUndef(value) || parseInt(value) < 0){
                    this.runtime.message.push(this.$app.getFormMessageClass(control.id, control.caption,
                        "Cota de TVA este gresita!"));
                }
                this.setPostNewInvoice(control, value);
            }
        },
        data () {
            return {
                invoiceNumber: '...'
            }
        }
    }

</script>

<style scoped></style>


