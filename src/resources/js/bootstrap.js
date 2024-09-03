import $ from 'jquery';
import select2 from 'select2';
import { _dttable, deleteData, reloadTable } from './func';

window.jQuery = window.$ = $

select2($);

// window.select2 = select2($);

window._dttable = _dttable;

window.deleteData = deleteData;

window.reloadTable = reloadTable;
