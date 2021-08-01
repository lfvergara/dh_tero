SELECT   NN.ID_NOTICE AS id_deuda,
           N.id_customer AS id_cliente,
           NN.NOTICE_NUMBER AS factura,
           NN.ID_SUPPLY AS suministro,
           N.SEND_DATE AS fecha_emision,
           N.DISPATCH_COLL_DATE AS fecha_puestacobro,
           NN.BILL_DATE AS fecha_factura,
           N.OVERDUE_DATE AS fecha_vencimiento,
           N.LAST_PAYMENT_DATE AS fecha_2vencimiento,
           N.NEXT_OVERDUE_DATE AS fecha_proximo_vencimiento,
           N.BILL_PERIOD AS periodo_factura,
           LARIOJA.GCCB_BILL_NOTICE_TYPE.NAME_TYPE AS TIP_REC,
           B.TOTAL_AMOUNT IMP_ENERGIA,
           AGUA.IMP_AGUA IMP_AGUA,
           N.PENDING_AMOUNT AS imp_total,
           N.COLLECTION_STATUS,
           BS.NAME_TYPE ESTADO_FACT,
           N.PAYMENT_DATE,
           ' ' FECHA_ENV_PROC_COBR,
           LARIOJA.GCCOM_AGENCY.NAME_TYPE,
           LARIOJA.GCCOM_BRANCH.NAME_TYPE,
           NN.RECORD_SEQUENCE AS rec_sec,
           NN.SUPPLY_SEQUENCE AS nis_sec,
           B.PRINTFARE AS tarifa,
           B.CONS_TOTAL AS consumo,
           LPAD (NN.SALES_POINT, 4, '0') AS puntoventa,
           LPAD (NN.NOTICE_NUMBER, 8, '0') AS deuda_num,
           NV.NAME2 AS ref_nombre,
           BLS.POWER_MAX AS pot_contratada
    FROM   GCCB_NIR_NOTICE NN,
           GCCB_NOTICE N,
           GCCB_NOTICE_BILL NB,
           GCCOM_BILL B,
           GCCOM_BILL_STATUS BS,
           (SELECT   N1.ID_NOTICE ID_NOTICE, NB1.NOTICE_BILL_AMOUNT IMP_AGUA
              FROM   GCCB_NOTICE N1, GCCB_NOTICE_BILL NB1
             WHERE   N1.ID_NOTICE = NB1.ID_NOTICE
                     AND (NB1.BILL_TYPE = 'TFGEN20001')) AGUA,
           LARIOJA.GCCOM_AGENCY,
           LARIOJA.GCCOM_BRANCH,
           LARIOJA.GCCB_BILL_NOTICE_TYPE,
           GCCD_RELATIONSHIP R,
           LARIOJA.GCCB_BILL_NOTICE_VOUCHER NV,
           GCCOM_BILLING_SERVICE BLS,
           GCCOM_CONTRACTED_SERVICE CSS,
           GCCB_NOTICE_COMPOSITION NC
   WHERE       N.ID_NOTICE = NN.ID_NOTICE
           AND N.ID_NOTICE = NB.ID_NOTICE
           AND B.ID_BILL = NB.ID_BILL
           AND R.ID_RELATIONSHIP = N.ID_CUSTOMER
           AND N.COLLECTION_STATUS = BS.COD_DEVELOP
           AND N.ID_NOTICE = AGUA.ID_NOTICE(+)
           AND N.ID_AGENCY = LARIOJA.GCCOM_AGENCY.ID_AGENCY(+)
           AND N.ID_BRANCH = LARIOJA.GCCOM_BRANCH.COD_BRANCH(+)
           AND N.BILL_NOTICE_TYPE = LARIOJA.GCCB_BILL_NOTICE_TYPE.COD_DEVELOP
           AND NN.VOUCHER_TYPE = NV.ID_VOUCHER_TYPE_RG1361
           AND NV.COD_DEVELOP = N.BILL_NOTICE_TYPE
           AND N.ID_CONTRACT = CSS.ID_CONTRACT
           AND BLS.ID_CONTRACTED_SERVICE = CSS.ID_CONTRACTED_SERVICE
           AND N.ID_NOTICE = NC.ID_NOTICE(+)
           AND (NC.ID_STATEMENT_LOT IS NULL
                OR (NC.ID_STATEMENT_LOT IN
                          (SELECT   ID_STATEMENT_LOT
                             FROM   GCPR_PRINTING_LOT
                            WHERE   PRINTING_LOT_STATUS = 'PRLOTST004')))
           AND ( (R.DOC_NUMBER = '%DNI%'
                  AND N.COLLECTION_STATUS IN
                           ('ESTFAC0005',
                            'ESTFAC0020',
                            'ESTIMP1001',
                            'ESTIMP1002',
                            'ESTIMP1003',
                            'ESTIMP1004',
                            'ESTIMP1005')
                  AND NB.BILL_TYPE = 'TFGEN00001')
                AND N.BILL_NOTICE_TYPE NOT IN ('BNOTYP0046',
                     'BNOTYP0047',
                     'BNOTYP0045',
                     'BNOTYP0040',
                     'BNOTYP0102',
                     'BNOTYP0103',
                     'BNOTYP0107',
                     'BNOTYP0108',
                     'BNOTYP0000'))
		   AND N.ID_NOTICE NOT IN (SELECT ID_NOTICE
                                            FROM GCCB_EXTERNAL_COLLECTION EC
                                            WHERE EC.ID_SUPPLY = NN.ID_SUPPLY)
ORDER BY   NN.ID_SUPPLY, N.BILL_PERIOD
