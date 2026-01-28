/**
 * This configuration was generated using the CKEditor 5 Builder. You can modify it anytime using this link:
 * https://ckeditor.com/ckeditor-5/builder/?redirect=portal#installation/NoNgNARATAdA7DArBSIQE4CMm3qgDigBZEAGEAZnxDnSIvsQtKJBMXTiKJQgFMAdilJhgmMOJHjpAXUh44fAGYBjOBBlA===
 */

const {
	ClassicEditor,
	Autosave,
	BalloonToolbar,
	Bold,
	Essentials,
	Italic,
	Paragraph,
	Table,
	TableCaption,
	TableCellProperties,
	TableColumnResize,
	TableProperties,
	TableToolbar,
	Underline
} = window.CKEDITOR;

const LICENSE_KEY ='eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3ODc0NDMxOTksImp0aSI6ImJhNmYyNWE2LTgzYTctNGY2Ny1hZThmLTUyNWVhNjFhOTNmNyIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiXSwiZmVhdHVyZXMiOlsiRFJVUCIsIkUyUCIsIkUyVyJdLCJ2YyI6Ijc2NzJkZjBhIn0.S74FHpvyVgaymMnY9883M7WqFQ3TuWZMOI6hKxGHuE4gNQnX4PN0dleF6jd6fJ1o5g8t8LkoqxlAfcAkcj9a1A';

const editorConfig = {
	toolbar: {
		items: ['undo', 'redo', '|', 'bold', 'italic', 'underline', '|', 'insertTable'],
		shouldNotGroupWhenFull: false
	},
	plugins: [
		Autosave,
		BalloonToolbar,
		Bold,
		Essentials,
		Italic,
		Paragraph,
		Table,
		TableCaption,
		TableCellProperties,
		TableColumnResize,
		TableProperties,
		TableToolbar,
		Underline
	],
	balloonToolbar: ['bold', 'italic'],
	initialData:
		"",
	licenseKey: LICENSE_KEY,
	menuBar: {
		isVisible: true
	},
	placeholder: 'Digite seu conteúdo aqui!',
	table: {
		contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
	}
};

ClassicEditor.create(document.querySelector('#editor'), editorConfig);
