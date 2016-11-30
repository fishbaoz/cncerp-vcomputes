<?php /* Version 1.0 */

/**************************************************************************************
Locale language file for reports. This file can be broken out for apps that use
DEFINE statements. The report scripts and forms obtain their text definitions here.
This first part of this file may be broken out to a language file for apps that don't
use getttext for translation.
***************************************************************************************/

// Message definitions
define('RPT_SAVEDEF',_('您输入的名称是系统报表名称.请重新输入。'));
define('RPT_SAVEDUP',_('报表名已存在! 是否覆盖？'));
define('RPT_DUPDB',_('数据库发生错误。请检查sql语句。'));
define('RPT_BADFLD',_('数据库发生错误。请检查sql语句。'));
define('RPT_BADDATA',_('数据库发生错误。请检查sql语句。'));
define('RPT_EMPTYFIELD',_('数据为空。位于序列号：'));
define('RPT_DEFDEL',_('覆盖报表/表单将会删除原来的报表/表单！'));
define('RPT_NODATA',_('搜到的报表内没有数据！'));
define('RPT_NOROWS',_('没有记录！'));
define('RPT_WASSAVED',_(' 将被保存或者作为模板：'));
define('RPT_UPDATED',_('报表名已更新！'));
define('FRM_NORPT',_('请输入表单名。'));
define('RPT_NORPT',_('请输入报表名。'));
define('RPT_NORPTTYPE',_('请选择报表/表单类型！'));
define('RPT_REPDUP',_('您输入的名称已经占用。请重新输入表报名！'));
define('RPT_REPDEL',_('点击OK删除报表。'));
define('RPT_REPOVER',_('点击OK覆盖报表。'));
define('RPT_NOSHOW',_('没有报表可以显示！'));
define('RPT_NOFIELD',_('没有字段可以显示！'));
define('FRM_RPTENTER',_('输入表单名称。'));
define('RPT_RPTENTER',_('输入报表名称。'));
define('RPT_RPTNOENTER',_('(留空则文件名作为报表名)'));
define('RPT_MAX30',_('(最多30字符)'));
define('FRM_RPTGRP',_('Enter the group this form is a part of:'));
define('RPT_RPTGRP',_('Enter the group this report is a part of:'));
define('RPT_DEFIMP',_('选择要导入的报表.'));
define('RPT_RPTBROWSE',_('上传.'));

// Error messages for importing reports
define('RPT_IMP_ERMSG1',_('上传文件过大。见php.ini中upload_max_filesize设置项。'));
define('RPT_IMP_ERMSG2',_('上传文件过大。见php脚本中MAX_FILE_SIZE设置项。'));
define('RPT_IMP_ERMSG3',_('文件上传失败请重试。'));
define('RPT_IMP_ERMSG4',_('未选择上传文件。'));
define('RPT_IMP_ERMSG5',_('其他错误：'));
define('RPT_IMP_ERMSG6',_('不是指定类型的文件。'));
define('RPT_IMP_ERMSG7',_('上传的文件没有数据！'));
define('RPT_IMP_ERMSG8',_('上传的文件中的SQL语句不正确！'));
define('RPT_IMP_ERMSG9',_('导入完毕！'));
define('RPT_IMP_ERMSG10',_('未知错误。'));

// General definitions
define('RPT_ABSCISSA',_('横坐标'));
define('RPT_ACTIVE',_('可用'));
define('RPT_ALL',_('全部'));
define('RPT_ALIGN',_('对齐'));
define('RPT_ASSEMBLY',_('组装'));
define('RPT_BOTTOM',_('底部'));
define('RPT_BREAK',_('换行'));
define('RPT_CENTER',_('居中'));
define('RPT_COLUMN',_('列'));
define('RPT_COLOR',_('颜色'));
define('RPT_CUSTCOLOR',_('自定义颜色(范围 0-255)'));
define('RPT_CUSTOM',_('客户'));
define('RPT_DATE',_('日期'));
define('RPT_DEFAULT',_('默认'));
define('RPT_FALSE',_('否'));
define('RPT_FIELDS',_('输入框'));
define('RPT_FIFTH',_('第五'));
define('RPT_FILTER',_('条件'));
define('RPT_FORM',_('表单'));
define('RPT_FORMS',_('表单'));
define('RPT_FLDNAME',_('数据名称'));
define('RPT_FROM',_('从'));
define('RPT_FONT',_('字体'));
define('RPT_FOURTH',_('第四'));
define('RPT_GROUP',_('分组'));
define('RPT_HORIZONTAL',_('水平'));
define('RPT_INACTIVE',_('不可用'));
define('RPT_LEFT',_('左'));
define('RPT_LENGTH',_('长度'));
define('RPT_MOVE',_('移动'));
define('RPT_NO',_('No'));
define('RPT_NONE',_('无'));
define('RPT_ORDER',_('排序'));
define('RPT_ODINATE',_('横竖朝向'));
define('RPT_PAGE',_('页'));
define('RPT_PRIMARY',_('基本要素'));
define('RPT_PRINTED',_('已打印'));
define('RPT_RANGE',_('范围'));
define('RPT_REPORT',_('报表'));
define('RPT_REPORTS',_('报表'));
define('RPT_RIGHT',_('右'));
define('RPT_SHOW',_('显示'));
define('RPT_SECOND',_('第二'));
define('RPT_SEPARATOR',_('分隔'));
define('RPT_SELECT',_('选择一个表...'));
define('RPT_SLCTFIELD',_('选择一个数据项...'));
define('RPT_SEQ',_('顺序'));
define('RPT_SIXTH',_('第六'));
define('RPT_SIZE',_('尺寸'));
define('RPT_SORT',_('排序'));
define('RPT_STDCOLOR',_('标准色'));
define('RPT_STOCK',_('Stock'));
define('RPT_THIRD',_('第三'));
define('RPT_TO',_('到'));
define('RPT_TOP',_('顶部'));
define('RPT_TOTAL',_('总计'));
define('RPT_TRUE',_('是'));
define('RPT_TRUNCATE',_('截断'));
define('RPT_TRUNC',_('截断过长字符串'));
define('RPT_TYPE',_('类型'));
define('RPT_UNPRINTED',_('未打印'));
define('RPT_VERTICAL',_('垂直'));
define('RPT_YES',_('是'));

// Report and Form page title definitions
define('RPT_RPTFRM',_('报表/表单: '));
define('RPT_RPRBLDR',_('报表/表单向导 - '));
define('RPT_STEP1',_('菜单'));
define('RPT_STEP2',_('第 2 步'));
define('RPT_STEP3',_('第 3 步'));
define('RPT_STEP4',_('第 4 步'));
define('RPT_STEP5',_('第 5 步'));
define('RPT_STEP6',_('第 6 步'));
define('RPT_MENU',_('报表菜单'));
define('RPT_CRITERIA',_('设置查询条件'));
define('RPT_PAGESAVE',_('保存报表'));
define('RPT_PAGESETUP',_('报表页设置'));

// Button definitions - General
define('RPT_BTN_ADD',_('新增'));
define('RPT_BTN_ADDNEW',_('新增'));
define('RPT_BTN_BACK',_('返回'));
define('RPT_BTN_CANCEL',_('取消'));
define('RPT_BTN_CHANGE',_('修改'));
define('RPT_BTN_CONT',_('继续'));
define('RPT_BTN_COPY',_('拷贝'));
define('RPT_BTN_CPYRPT',_('作为模板'));
define('RPT_BTN_CRIT',_('设置查询条件'));
define('RPT_BTN_DB',_('数据库设置'));
define('RPT_BTN_DEL',_('删除'));
define('RPT_BTN_DELRPT',_('删除报表'));
define('RPT_BTN_EDIT',_('编辑'));
define('RPT_BTN_EXPCSV',_('导出CSV'));
define('RPT_BTN_EXPORT',_('导出'));
define('RPT_BTN_EXPPDF',_('导出PDF'));
define('RPT_BTN_FINISH',_('完成'));
define('RPT_BTN_FLDSETUP',_('字段设置'));
define('RPT_BTN_IMPORT',_('导入'));
define('RPT_BTN_PGSETUP',_('页面设置'));
define('RPT_BTN_PROP',_('属性'));
define('RPT_BTN_REPLACE',_('覆盖'));
define('RPT_BTN_REMOVE',_('删除'));
define('RPT_BTN_RENAME',_('重新命名'));
define('RPT_BTN_SAVE',_('保存'));
define('RPT_BTN_UPDATE',_('更新'));

// Report  Specific
define('RPT_RPTFILTER',_('查询条件: '));
define('RPT_GROUPBY',_('分组语句:'));
define('RPT_SORTBY',_('排序语句:'));
define('RPT_DATERANGE',_('数据范围:'));
define('RPT_CRITBY',_('查询条件:'));
define('RPT_ADMIN',_('管理员页面'));
define('RPT_BRDRLINE',_('边框'));
define('RPT_BOXDIM',_('区域大小(mm)'));
define('RPT_COL1W',_('列 1'));
define('RPT_COL2W',_('列 2'));
define('RPT_COL3W',_('列 3'));
define('RPT_COL4W',_('列 4'));
define('RPT_COL5W',_('列 5'));
define('RPT_COL6W',_('列 6'));
define('RPT_COL7W',_('列 7'));
define('RPT_COL8W',_('列 8'));
define('RPT_COL9W',_('列 9'));
define('RPT_COL10W',_('列 10'));
define('RPT_COL11W',_('列 11'));
define('RPT_COL12W',_('列 12'));
define('RPT_COL13W',_('列 13'));
define('RPT_COL14W',_('列 14'));
define('RPT_COL15W',_('列 15'));
define('RPT_COL16W',_('列 16'));
define('RPT_COL17W',_('列 17'));
define('RPT_COL18W',_('列 18'));
define('RPT_COL19W',_('列 19'));
define('RPT_COL20W',_('列 20'));
define('RPT_CRITTYPE',_('Type of Criteria'));
define('RPT_TYPECREATE',_('Select report or form type to create:'));
define('RPT_CWDEF',_('列宽(mm)(0表示不指定)'));
define('RPT_CUSTRPT',_('自定义报表'));
define('RPT_DATEDEF',_('默认日期'));
define('RPT_DATEFNAME',_('日期字段名 (table.fieldname)'));
define('RPT_DATEINFO',_('报表日期信息'));
define('RPT_DATEINST',_('Uncheck all boxes for date independent reports; 日期字段留空'));
define('RPT_DATELIST',_('日期字段列表<br />(check all that apply)'));
define('RPT_DEFRPT',_('默认报表'));
define('RPT_ENDPOS',_('结束位置(mm)'));
define('RPT_ENTRFLD',_('新建数据项'));
define('RPT_FLDLIST',_('字段列表'));
define('RPT_FILL',_('填充'));
define('RPT_FORMOUTPUT',_('选择一个表单'));
define('RPT_FORMSELECT',_('表单选择'));
define('RPT_GRPLIST',_('分组列表'));
define('RPT_HEIGHT',_('高'));
define('RPT_IMAGECUR',_('当前图片'));
define('RPT_IMAGESEL',_('图片选择'));
define('RPT_IMAGESTORED',_('选择图片'));
define('RPT_IMAGEDIM',_('图片尺寸(mm)'));
define('RPT_LINEATTRIB',_('线条属性'));
define('RPT_LINEWIDTH',_('线宽(pts)'));
define('RPT_LINKEQ',_('表关联条件 (SQL语法)<br />如: tablename1.fieldname1=tablename2.fieldname2'));
define('RPT_MYRPT',_('我的报表'));
define('RPT_NOBRDR',_('无边框'));
define('RPT_NOFILL',_('无填充'));
define('RPT_DISPNAME',_('显示的名称'));
define('RPT_PGCOYNM',_('公司名称'));
define('RPT_PGFILDESC',_('报表过滤描述'));
define('RPT_PGHEADER',_('标题信息/格式'));
define('RPT_PGLAYOUT',_('页面布局'));
define('RPT_PGMARGIN',_('页面补白'));
define('RPT_RNRPT',_('重新命名'));
define('RPT_PGTITL1',_('报表标题 1'));
define('RPT_PGTITL2',_('报表标题 2'));
define('RPT_RPTDATA',_('报表数据'));
define('RPT_RPTID',_('报表/表单ID'));
define('RPT_RPTIMPORT',_('报表导入'));
define('RPT_SORTLIST',_('排序信息'));
define('RPT_STARTPOS',_('开始位置(mm)(页面左上角)'));
define('RPT_TBLNAME',_('表格名称'));
define('RPT_TEXTATTRIB',_('文本属性'));
define('RPT_TEXTDISP',_('显示的文本'));
define('RPT_TEXTPROC',_('Text Processing'));
define('RPT_TBLFNAME',_('字段名 (table.fieldname)'));
define('RPT_TOTALS',_('报表总计'));
define('RPT_FLDTOTAL',_('Enter fields to total (Table.Fieldname)'));
define('RPT_WIDTH',_('宽'));

// Report Group Definitions
define('RPT_ORDERS',_('销售'));
define('RPT_PAYABLES',_('应付'));
define('RPT_PURCHASES',_('采购'));
define('RPT_RECEIVABLES',_('应收'));
define('RPT_INVENTORY',_('库存'));
define('RPT_MANUFAC',_('制造'));
define('RPT_GL',_('总账'));
define('RPT_AM',_('资产经理'));
define('RPT_PC',_('小额现金/零用现金'));
define('RPT_FINANCIAL',_('会计报表'));
define('RPT_MISC',_('其他'));

// Form Group Definitions
define('RPT_BANKCHK',_('银行'));
define('RPT_BANKDEPSLIP',_('银行保证金'));
define('RPT_COLLECTLTR',_('Collection Letters'));
define('RPT_CUSTLBL',_('标签 - 客户'));
define('RPT_CUSTQUOTE',_('报价单'));
define('RPT_CUSTSTATE',_('客户条款'));
define('RPT_INVPKGSLIP',_('货物清单'));
define('RPT_PURCHORD',_('采购订单'));
define('RPT_SALESORD',_('销售订单'));
define('RPT_SALESREC',_('销售发票'));
define('RPT_VENDLBL',_('标签 - 制造商'));

// Form Processing Definitions
define('FRM_DATALINE',_('行'));
define('FRM_DATABLOCK',_('块'));
define('FRM_DATATABLE',_('表'));
define('FRM_DATATOTAL',_('总计'));
define('FRM_FIXEDTXT',_('固定文本框'));
define('FRM_NOIMAGE',_('无图'));
define('FRM_IMAGE',_('图(JPG/PNG)'));
define('FRM_RECTANGLE',_('长方形'));
define('FRM_LINE',_('行'));
define('FRM_COYDATA',_('抬头信息行'));
define('FRM_COYBLOCK',_('抬头信息块'));
define('FRM_PAGENUM',_('页码'));
define('FRM_UPPERCASE',_('大写'));
define('FRM_LOWERCASE',_('小写'));
define('FRM_NEGATE',_('负数'));
define('FRM_RNDR2',_('四舍五入(2位小数)'));
define('FRM_CNVTDLR',_('转换美元'));
define('FRM_CNVTEURO',_('转换欧元'));
define('FRM_SPACE1',_('单空格'));
define('FRM_SPACE2',_('双空格'));
define('FRM_COMMA',_('逗号'));
define('FRM_COMMASP',_('逗号和空格'));
define('FRM_NEWLINE',_('换行符'));
define('FRM_SEMISP',_('分号和空格'));

// Paper Size Definitions
define('RPT_PAPER',_('纸张尺寸:'));
define('RPT_ORIEN',_('横竖朝向:'));
define('RPT_MM',_('mm'));
define('RPT_A3',_('A3'));
define('RPT_A4',_('A4'));
define('RPT_A5',_('A5'));
define('RPT_LEGAL',_('Legal'));
define('RPT_LETTER',_('Letter'));
define('RPT_PORTRAIT',_('竖排'));
define('RPT_LANDSCAPE',_('横排'));

// Font Names
define('RPT_COURIER',_('Courier'));
define('RPT_HELVETICA',_('Helvetica'));
define('RPT_TIMES',_('Times'));

// General Number Definitions
define('RPT_1',_('1'));
define('RPT_2',_('2'));
define('RPT_3',_('3'));
define('RPT_4',_('4'));
define('RPT_5',_('5'));
define('RPT_6',_('6'));
define('RPT_7',_('7'));
define('RPT_8',_('8'));
define('RPT_9',_('9'));
define('RPT_10',_('10'));
define('RPT_12',_('12'));
define('RPT_14',_('14'));
define('RPT_16',_('16'));
define('RPT_18',_('18'));
define('RPT_20',_('20'));
define('RPT_24',_('24'));
define('RPT_28',_('28'));
define('RPT_32',_('32'));
define('RPT_36',_('36'));
define('RPT_40',_('40'));
define('RPT_50',_('50'));

// Color definitions
define('RPT_BLACK',_('黑'));
define('RPT_BLUE',_('蓝'));
define('RPT_RED',_('红'));
define('RPT_ORANGE',_('橙'));
define('RPT_YELLOW',_('黄'));
define('RPT_GREEN',_('绿'));
define('RPT_WHITE',_('白'));

// Definitions for date selection dropdown list
define('RPT_TODAY',_('今日'));
define('RPT_WEEK',_('本周'));
define('RPT_WTD',_('本周至'));
define('RPT_MONTH',_('本月'));
define('RPT_MTD',_('本月至'));
define('RPT_QUARTER',_('本季度'));
define('RPT_QTD',_('本季度至'));
define('RPT_YEAR',_('本年'));
define('RPT_YTD',_('本年至'));
?>