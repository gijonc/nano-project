import axios from 'axios';

const BASE_URL = 'http://localhost:8000';
const DATA_DIR = 'nano-project/api/public';

export { Company_Settings };

// TODO: using class?
class Company_Settings {

	readEntry () {
		const table = 'cs';
		const url = `${BASE_URL}/${DATA_DIR}/${table}/read`;

		return axios.get(url).then(response => response.data.company_settings);
	}

	createEntry (entry_data) {
		const table = 'cs';
		const url = `${BASE_URL}/${DATA_DIR}/${table}/add`;

		return axios.post(url, JSON.stringify(entry_data))
			.then(response => response.data);

	}

	editEntry(entry_data) {
		const table = 'cs';
		const url = `${BASE_URL}/${DATA_DIR}/${table}/update`;

		return axios.post(url, JSON.stringify(entry_data))
			.then(response => response.data);

	}

	deleteEntry(entry_data) {
		const table = 'cs';
		const url = `${BASE_URL}/${DATA_DIR}/${table}/delete`;

		return axios.post(url, JSON.stringify(entry_data))
			.then(response => response.data);

	}

}
