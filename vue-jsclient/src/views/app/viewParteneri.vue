<template>
    <div class="ff-workbench" ref="refWorkBench">
        <tab-parteneri ref="refTab"
            :pConfig=this.tabConfig
            @emitClickTab="emitClickTab"
        >
            <template v-slot:tabs>
                <div class="tab" :id="this.$constTab.getIdTab('1p')">
                    <div class="up-line"></div>
                    <my-grid ref="gridParteneri"
                             :pConfig=this.gridConfig
                              @emitSelectDataOnGrid = "emitSelectDataOnGrid"
                    ></my-grid>
                </div>
                <div class="tab" :id="this.$constTab.getIdTab('3p')">
                    <div class="up-line"></div>
                    <div class="antet-tab">
                        <div class="buttons-container"></div>
                        <div class="title">{{this.tabs.tab03.title}}</div>
                    </div>

                    <my-grid :ref=this.REF_GRID_INVOICES
                             :pConfig=this.gridConfigPartnerInvoices
                             @emitSelectDataGridInvoices = "emitSelectDataGridInvoices"
                    ></my-grid>

                </div>
                <div class="tab" :id="this.$constTab.getIdTab('2p')">
                    <div class="up-line"></div>
                    <form-partener :ref=this.REF_PARTENER_EDIT
                        @emitNewRecord = "emitNewRecord"
                    ></form-partener>
                </div>
                <div class="tab" :id="this.$constTab.getIdTab('4p')">
                    <div class="up-line"></div>
                    <form-partener-adrese :ref="this.REF_LISTA_ADRESS"></form-partener-adrese>
                </div>
                <div class="tab" :id="this.$constTab.getIdTab('5p')">
                    <div class="up-line"></div>
                    <form-partener-banc :ref="this.REF_LISTA_BANK"></form-partener-banc>

                </div>
            </template>
        </tab-parteneri>

    </div>
</template>

<script>
    import Tab          from "@/components/base/Tab";
    import Gridul       from '@/components/base/Gridul';
    import formPartener from '@/components/app/form/formPartener';
    import formPartenerAdrese from '@/components/app/form/formPartenerAdrese';
    import formPartenerBancAcount from '@/components/app/form/formPartenerBancAcount';
    import Button       from "@/components/base/Button";
    import Lista        from "@/components/base/Lista";

    export default {
		components: {
            'tab-parteneri': Tab,
            'my-grid': Gridul,
            'form-partener': formPartener,
            'form-partener-adrese': formPartenerAdrese,
            'form-partener-banc': formPartenerBancAcount,
            'my-button': Button,
            'my-list': Lista
        },
		name: "view-parteneri",
		created() {
		    this.REF_PARTENER_EDIT = 'refPartenerEdit',
            this.REF_GRID_INVOICES = 'refGridParteneriInvoices',
            this.REF_LISTA_ADRESS = 'refListaAdress',
            this.REF_LISTA_BANK = 'refListaBanca',
            this.TAB_EDIT = {id: '2p', urlGetDate: this.$url.getUrl('partenerGetData')},
		    this.TAB_PARTENERI = {id: '1p'},
            this.TAB_FACTURI = {id: '3p', isLoading: false},
            this.TAB_ADRESE = {id: '4p', isLoading: false},
            this.TAB_BANC_COUNT = {id: '5p', isLoading: false},
            this.ICON_ADD_PARTENER =  this.$constComponent.ICON_ADD_PERSON("blue");
		    this.runtime = {
		        additionalFilter: new Array(),
                sendDataToServer: false
            };
            this.tabConfig = {
                header: [
                    this.$constTab.getHeader('1p','Parteneri'),
                    this.$constTab.getHeader('3p','Facturi'),
                    this.$constTab.getHeader('2p','Date partener'),
                    this.$constTab.getHeader('4p','Adrese'),
                    this.$constTab.getHeader('5p','Conturi bancare'),
                ],
                actionButtonHeader: [
                    //this.$constList.getActionButton(7, 'Altceva din functie', 'altCeca', this.$constGrid.getIcon('fas','skull', '#adad00')),
                ],
                defaultTabId: '1p',
                tabsWidth: '1050px'
            },
            this.gridConfig = {
                    header: [
                        this.$constGrid.HEADER.getHeader(1,'Nume',450,'cNume', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, true, true, true, null, null),
                        this.$constGrid.HEADER.getHeader(2,'Organizare',180,'cTipAbrev', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, true, true, true, 't_tip_organizare_juridica.cTipAbrev', null),
                        this.$constGrid.HEADER.getHeader(3,'Registrul comertului',180,'regcom', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, true, false, true, null, null),
                        this.$constGrid.HEADER.getHeader(4,'RO',70,'ro_', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, false, false, true, null, null),
                        this.$constGrid.HEADER.getHeader(5,'Cui',100,'cui', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, false, false, true, null, null)
                    ],
                    actionButtonHeader: [
                        //this.$constGrid.getActionButton(7, 'Altceva din functie', 'altCeca', this.$constGrid.getIcon('fas','skull', '#adad00')),
                        // this.$constGrid.getActionButton(8, 'Print din functie', 'invoicePrint', this.$constGrid.ICON_PRINT)
                        //this.$constGrid.getActionButton(9, 'Edit din functie', 'deleteCeva', this.$constGrid.ICON_DELETE),
                        //this.$constGrid.getActionButton(10, 'Delete din functie', 'editCeva', this.$constGrid.ICON_EDIT)
                    ],
                    returnField: ['cNume', 'cui'],             // return field and edit when selected row
                    cfg: {
                        width: 1100,
                        height: 500,
                        urlData: 'gridListParteneri',
                        loadOnCreate: true,
                    },
                    toolbar: {
                        show: true,
                        fieldShow: {
                            field: ['cNume'],        // shon on selection with mouse or keyboard
                            separator: " ",
                            includeIdPk: true
                        },
                        actionButton : [
                            // this.$constGrid.getActionButton( null,  'Print din functie', 'invoicePrintToolbar', this.$constGrid.ICON_PRINT),
                            // this.$constGrid.getActionButton( null,  'Edit din functie',   'deleteCevaToolbar', this.$constGrid.ICON_DELETE),
                            // this.$constGrid.getActionButton( null,  'Delete din functie', 'editCevaToolbar', this.$constGrid.ICON_EDIT)
                        ]
                    },
                    emitSelectData: 'emitSelectDataOnGrid',
                    paginate: {
                        nrButtonShow: 10,
                        recordsPerPage: 21
                    }
                },
                this.gridConfigPartnerInvoices = {
                    header: [
                        this.$constGrid.HEADER.getHeader(1,'Data factura',120,'data_f', this.$constGrid.HEADER.CAPTION_TYPE_FIELD,          true,  true,  true, null, this.$constGrid.ALIGN_TEXT_CENTER),
                        this.$constGrid.HEADER.getHeader(2,'Nr. factura',150,'nr_f', this.$constGrid.HEADER.CAPTION_TYPE_FIELD,             true,  false, true, null, null),
                        this.$constGrid.HEADER.getHeader(3,'TVA',30,'nProcTVA', this.$constGrid.HEADER.CAPTION_TYPE_FIELD,                  false,  false, false, null, this.$constGrid.ALIGN_TEXT_CENTER),
                        this.$constGrid.HEADER.getHeader(4,'Total fara TVA',110,'nSumaFaraTva', this.$constGrid.HEADER.CAPTION_TYPE_FIELD,  false, false, false, null, this.$constGrid.ALIGN_TEXT_RIGHT),
                        this.$constGrid.HEADER.getHeader(5,'Total TVA',110,'nSumaTVA', this.$constGrid.HEADER.CAPTION_TYPE_FIELD,           false, false, false, null, this.$constGrid.ALIGN_TEXT_RIGHT),
                        this.$constGrid.HEADER.getHeader(6,'Total',120,'nTotal', this.$constGrid.HEADER.CAPTION_TYPE_FIELD,                 false, false, false, null, this.$constGrid.ALIGN_TEXT_RIGHT)
                        // this.$constGrid.HEADER.getHeader(7,'action',50,null, this.$constGrid.HEADER.CAPTION_TYPE_ACTION, false, false, false)
                    ],
                    actionButtonHeader: [
                        // this.$constGrid.getActionButton(8, 'Altceva din functie', 'altCeca', this.$constGrid.getIcon('fas','skull', '#adad00'))
                        // this.$constGrid.getActionButton(8, 'printeaza factura', 'invoicePrint', this.$constGrid.ICON_PRINT)
                        //this.$constGrid.getActionButton(9, 'Edit din functie', 'deleteCeva', this.$constGrid.ICON_DELETE),
                        //this.$constGrid.getActionButton(10, 'Delete din functie', 'editCeva', this.$constGrid.ICON_EDIT)
                    ],
                    returnField: ['data_f','nr_f'],             // return field and edit when selected row
                    cfg: {
                        width: 1100,
                        height: 500,
                        urlData: 'invocesListPartener',
                        loadOnCreate: false,
                    },
                    toolbar: {
                        show: true,
                        fieldShow: {
                            field: ['data_f','nr_f'],        // show on selection with mouse or keyboard
                            separator: " ",
                            includeIdPk: true
                        },
                        actionButton : [
                            // this.$constGrid.getActionButton( null,  'Print din functie', 'invoicePrintToolbar', this.$constGrid.ICON_PRINT),
                            // this.$constGrid.getActionButton( null,  'Edit din functie',   'deleteCevaToolbar', this.$constGrid.ICON_DELETE),
                            // this.$constGrid.getActionButton( null,  'Delete din functie', 'editCevaToolbar', this.$constGrid.ICON_EDIT)
                        ]
                    },
                    emitSelectData: 'emitSelectDataGridInvoices',
                    paginate: {
                        nrButtonShow: 10,
                        recordsPerPage: 19
                    }
                }
		},
        mounted () {
		    this.$refs.refTab.goToTab(this.tabConfig.defaultTabId);
            this.emitSelectDataOnGrid();
            // this.$refs.refTab.tabOnOff('2p','off');
        },
		methods: {
            emitNewRecord: function (newId){
                this.post.idPk = newId;
                this.changePartenerSelected = true; // resetez inregistrarea selectata
                this.emitSelectDataOnGrid();
            },
		    emitClickTab: function (idTab) {
		        if(idTab == this.TAB_EDIT.id) {
                    this.$refs[this.REF_PARTENER_EDIT].getDataPartener(this.post.idPk);

                } else if(idTab == this.TAB_PARTENERI.id) {
                    if(this.changePartenerSelected){
                        this.changePartenerSelected = false;
                        this.$refs.gridParteneri.resetSelectionRow();

                        this.additionlFilterInvoiceData();
                    }

                }else if(idTab == this.TAB_FACTURI.id) {
		            if(!this.TAB_FACTURI.isLoading) {
                        this.TAB_FACTURI.isLoading = true;

                        this.$refs[this.REF_GRID_INVOICES].setAdditionalFilter(this.runtime.additionalFilter);
                        this.$refs[this.REF_GRID_INVOICES].goToPage(null, '1');
                    }
                }else if(idTab == this.TAB_ADRESE.id) {
                    if(!this.TAB_ADRESE.isLoading) {
                        this.TAB_ADRESE.isLoading = true;

                        this.$refs[this.REF_LISTA_ADRESS].showList({idPartner: this.post.idPk});
                    }
                }else if(idTab == this.TAB_BANC_COUNT.id) {
                    if(!this.TAB_BANC_COUNT.isLoading) {
                        this.TAB_BANC_COUNT.isLoading = true;
                        this.$refs[this.REF_LISTA_BANK].showList({idPartner: this.post.idPk});
                    }
                }



                // privateSetIdAndTitle
            },
            emitSelectDataGridInvoices: function () {
                 // console.log('am selectat o factura');

            },
            emitSelectDataOnGrid: function (selectData) {
                // console.log('am selectat un partener');

		        let onOff = 'on';
		        if(this.$check.isUndef(selectData)) {
                    onOff = 'off';
                    this.post.idPk = -1;
                } else {
                    this.post.idPk = selectData.idPk;
                    this.TAB_FACTURI.isLoading = false;
                    this.TAB_ADRESE.isLoading = false;
                    this.TAB_BANC_COUNT.isLoading = false;
                    this.tabs.tab03.title = selectData.cNume + '    ['+selectData.cui + ']';
                    this.$refs[this.REF_LISTA_ADRESS].setIdAndTitle(this.tabs.tab03.title, this.post.idPk);
                    this.$refs[this.REF_LISTA_BANK].setIdAndTitle(this.tabs.tab03.title, this.post.idPk);
                }

                this.$refs.refTab.tabOnOff('2p', onOff);
                this.$refs.refTab.tabOnOff('3p', onOff);
                this.$refs.refTab.tabOnOff('4p', onOff);
                this.$refs.refTab.tabOnOff('5p', onOff);

                this.additionlFilterInvoiceData();

            },
            additionlFilterInvoiceData: function () {
                this.runtime.additionalFilter = [
                    {'id_part': this.post.idPk}
                ];
            }
		},
		data () {
			return {
                post: { idPk: null },
                postAdress: { idPk: null },
                changePartenerSelected: false,
			    tabs: {
			        tab01: {},
                    tab02: {},
                    tab03: {title: '...'},
                    tab04: {},
                    tab05: {}
                }
            }
		}
	}

</script>

<style scoped></style>


