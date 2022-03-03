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

    <validate-window ref="refYesNoDeleteItemInvoice"
                     :cWidth=400
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoDeleteItemInvoice"
    ></validate-window>

    <validate-window ref="refYesNoNew"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoButtonNew"
    ></validate-window>

    <validate-window ref="refYesNoSaveInvoice"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoSaveInvoice"
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

            <my-list
                :ref = this.cfgtime.CFG_INVOICE_DETAIL_LIST.ref
                :pConfig=this.cfgtime.CFG_INVOICE_DETAIL_LIST
                @emitListRowSelection = 'emitDetailListRowSelection'
                @emitStergArticol = 'emitStergArticol'
                @emitFinallyCustomResponse = 'emitListaSumary'
            ></my-list>

            <br>
            <div class="form-rezumat-right">
                <table class="ff-form-table">
                    <tr>
                        <td class="label-left bold">
                            <label>Valoare fara TVA:</label></td>
                        <td class="control">
                            {{this.invoiceRezumat.sumaFaraTva}}
                        </td>
                        <td class="label-left bold">
                            <label>&nbsp;&nbsp;&nbsp;Valoare TVA:</label></td>
                        <td class="control">
                            {{this.invoiceRezumat.sumaTva}}
                        </td>
                        <td class="label-left bold">
                            <label>&nbsp;&nbsp;&nbsp;Total:</label></td>
                        <td class="control">
                            {{this.invoiceRezumat.total}}
                        </td>
                    </tr>
                </table>
            </div>


        </template>
        <template v-slot:slotButton>
            <div class="buttons-left">
                <my-button :ref=this.cfgtime.REF_BUTTON_SAVE_INVOICE @click="this.saveInvoice" :heightButton=22 :buttonType=0 title="salvez factura in baza de date">Salvez factura</my-button>
            </div>
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
    import Lista          from "@/components/base/Lista";

    export default {
        components: {
            'validate-window': AlertWindow,
            'form-tab': FormTab,
            'my-dropdown-search': DropDownSearch,
            'my-dds': DropDownSimple,
            'my-datetime': InputDateTime,
            'my-inputField': InputField,
            'my-button': Button,
            'my-list': Lista

        },
        name: "form-invoice-make",
        created() {
            this.REF_FORM = 'refFormInvoices';
            this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
	            message: [],
                postNewInvoices: { idPk: null, field: {}, sqlAction: null},
                postNewItem: { idPk: null, idInvoice: null, field: {}, sqlAction: null},
                postDeleteAntetInvoices: { idPk: null},
                postDeleteItemInvoices: { idPk: null},
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
                REF_BUTTON_SAVE_INVOICE:    'refSaveInvoice',
                URL_NEW_INVOICE:            this.$url.getUrl('insertInvoiceAntet'),
                URL_CHECK_WORKING_INVOICE:  this.$url.getUrl('checkWorkingInvoice'),
                URL_DELETE_ANTET_INVOICE:   this.$url.getUrl('deleteInvoiceAntet'),
                URL_INSERT_INVOICE_ARTICOL: this.$url.getUrl('insertInvoiceArticol'),
                URL_DELETE_INVOICE_ITEM:    this.$url.getUrl('deleteItemDetailInvoice'),
                URL_SAVE_INVOICE:           this.$url.getUrl('saveInvoice'),
                TVA: 19,
                CFG_INVOICE_DETAIL_LIST : {
                    ref: 'refDetailList',
                    header: [
                        this.$constList.getHeader(1, 'Nr.', 20, 'row_num', this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER  ),
                        this.$constList.getHeader(2, 'Servicii', 750, 'cText', this.$constList.HEADER.CAPTION_TYPE_FIELD ),
                        this.$constList.getHeader(3, 'Valoare', 100, 'nSumaFaraTva', this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT  ),
                        this.$constList.getHeader(4, 'Valoare TVA', 100, 'nSumaTva', this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT  ),
                        this.$constList.getHeader(5, 'Action', 100, 'null', this.$constList.HEADER.CAPTION_TYPE_ACTION)
                    ],
                    recordActionButon: [
                        this.$constList.getActionButton(4, 'sterg articol', 'emitStergArticol', this.$constGrid.ICON_DELETE, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null)
                        //this.$constList.getActionButton(5, 'adresa implicita', 'emitAdresaImplicita', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('ro', false)),   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
                        // this.$constList.getActionButton(6, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00'))
                    ],
                    cfg: { urlData: 'detailInvoiceList', loadOnCreate: false,
                           filedNameForCheckBox: 'activ',
	                       headerLenghtActivate: true,                         // tine cont de lungimea coloanelor setate in header
                           emitListRowSelection: 'emitListRowSelection'}
                },
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

                 // console.log(this.runtime.antetData);

            },
            saveInvoice: function (){
                if(!this.runtime.sendDataToServer) {
                    this.$refs.refYesNoSaveInvoice.setCaption("Salvez");
                    this.$refs.refYesNoSaveInvoice.setMessage("Salvez factura in baza de date ?");
                    this.$refs.refYesNoSaveInvoice.show();
                }

                if(this.runtime.sendDataToServer) {
                    this.runtime.sendDataToServer = false;

                    this.axios
                        .post(this.cfgtime.URL_SAVE_INVOICE, this.runtime.antetData)
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
                            this.checkWorkingInvoice();
                            this.$refs[this.REF_FORM].showModal(false);
                        });

                }
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
                        }
                        else {

                        }
                    })
                    .catch(error => console.log(error))
                    .finally(() => {
                        this.showListItems();
                        this.$refs[this.REF_FORM].showModal(false);
                    });

                // console.log(this.runtime.postNewItem);
            },
            deleteItemInvoice: function() {

                if(!this.runtime.sendDataToServer){
                    this.$refs.refYesNoDeleteItemInvoice.setCaption("Sterg elementul din factura?");
                    this.$refs.refYesNoDeleteItemInvoice.setMessage("Datele sterse nu mai pot fi recuperate.");
                    this.$refs.refYesNoDeleteItemInvoice.show();
                }

                if(this.runtime.sendDataToServer) {
                    this.runtime.sendDataToServer = false;

                    this.axios
                        .post(this.cfgtime.URL_DELETE_INVOICE_ITEM, this.runtime.postDeleteItemInvoices)
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
            showListItems: function(){

                let $id = 0;
                if(!this.$check.isUndef(this.runtime.antetData)){
                    $id = this.runtime.antetData.id;
                }
                this.$refs[this.cfgtime.CFG_INVOICE_DETAIL_LIST.ref].showList({idInvoice: $id});
            },
            emitListaSumary: function(sumarInvoice){
                this.invoiceRezumat.sumaFaraTva = sumarInvoice.sumaFaraTva;
                this.invoiceRezumat.sumaTva = sumarInvoice.sumaTva;
                this.invoiceRezumat.total = sumarInvoice.total;
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
                        this.showListItems();
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
            emitStergArticol: function (button){
                let tr = button.closest('tr');
                this.runtime.postDeleteItemInvoices.idPk = tr.getAttribute('idPk');
                this.deleteItemInvoice();
            },
            emitDetailListRowSelection: function(target){
                if(target.tagName == 'DIV'){
                   // do nothing
                }
            },
            emitTemplate: function (data){
                this.$refs[this.cfgtime.INPUT_TEXT_FACTURA.ref].setValue(data.text);
            },
            emitYesNoSaveInvoice: function (yes){
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
                    this.saveInvoice();
                }else{
                    this.runtime.sendDataToServer = false;
                }
            },
            emitYesNoDeleteItemInvoice: function (yes){
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
                    this.deleteItemInvoice();
                }else{
                    this.runtime.sendDataToServer = false;
                }
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
                    this.$refs[this.cfgtime.REF_BUTTON_SAVE_INVOICE].disable(false);
                }

                if(this.runtime.mode == this.$constFROM.MODE_NEW) {
                    readOnly = false;
                    this.resetPostNewInvoice();
                    this.$refs[this.cfgtime.REF_BUTTON_ADD_INVOICE].disable(readOnly);
                    this.$refs[this.cfgtime.REF_BUTTON_REMOVE_INVOICE].disable(true);
                    this.$refs[this.cfgtime.REF_BUTTON_ADD_ITEM].disable(true);
                    this.$refs[this.cfgtime.REF_BUTTON_SAVE_INVOICE].disable(true);
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
                let cfg = this.$app.cfgInputDateTimeField("invoiceDate", 11, 80);
                cfg.setValidateFunction(this.validateInvoiceDate);
                cfg.setCaption("Data factura");
                cfg.setMandatory(true);
                return cfg;
            },
            cfgTva: function(){
                let cfg = this.$app.cfgInputField("tva", null, 35);
                cfg.setValidateFunction(this.validateTVA);
                cfg.setCaption("TVA");
                cfg.setMandatory(true);
                cfg.setMaska("");
                return cfg;
            },
            cfgTextFactura: function(){
                let cfg = this.$app.cfgInputField("articolFactura", null, 650);
                cfg.setValidate(3,250);
                cfg.setValidateFunction(this.validateTextFactura);
                cfg.setCaption("Articol factura");
                cfg.setMandatory(true);
                cfg.setMaska("");
                return cfg;
            },
            cfgSuma: function (){
                let cfg = this.$app.cfgInputField("sumaArticol", null, 100);
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
                invoiceNumber: '...',
                invoiceRezumat: {total: 0.00, sumaFaraTva: 0.00, sumaTva: 0.00}
            }
        }
    }

</script>

<style scoped></style>


