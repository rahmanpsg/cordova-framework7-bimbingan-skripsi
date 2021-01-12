class formProses {
	constructor(url) {
		this.url = url;
	}

	tambah(tbl, data) {
		const send = {
			manajemen: 'tambah',
			tbl: tbl,
			data: data
		}

		const res = app.request.promise.post(`${this.url}manajemenBB`, send, 'json');

		return res;
	}

	update(tbl, data, where = {}) {
		const send = {
			manajemen: 'update',
			tbl: tbl,
			data: data,
			where: where
		}

		const res = app.request.promise.post(`${this.url}manajemenBB`, send, 'json');

		return res;
	}

	upload(formData) {
		const res = app.request.promise({
			url: `${this.url}uploadDokumen`,
			type: 'POST',
			data: formData,
			dataType: 'json'
		})

		return res;
	}

	getData(data = {}, url = 'getData', type = 'GET') {
		const res = app.request.promise({
			type: type,
			url: this.url + url,
			dataType: 'json',
			data: data,
			// async: false
		})

		return res;
	}

	getWaktu() {
		const res = app.request({
			url: this.url + 'getWaktu',
			async: false
		});

		return res.response;
	}

	createID(data = {}, type = 'POST') {
		const res = app.request({
			type: type,
			url: this.url + 'generate_id',
			dataType: 'json',
			data: data,
			async: false
		})

		return JSON.parse(res.response);
	}

	async cekData(tbl, send) {
		const res = app.request({
			type: "POST",
			url: this.url + 'cekData',
			dataType: 'json',
			data: {
				tabel: tbl,
				data: send
			},
			async: false
		})

		return await res;
	}
}