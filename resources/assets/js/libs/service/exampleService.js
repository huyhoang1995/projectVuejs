const exampleService = {
    data: {
        list: (freeText, page, perPage) => {
            return {
                freeText: freeText || '',
                page: page || 1,
                perPage: perPage || 10,
            }
        },
        update: (name, age, address) => {
            return {
                name: name || '',
                age: age || '',
                address: address || '',
            }
        }   
    },
    action: {
        list: (data) => {
            let url = siteUrl + '/rest/example?' + $.param( data, true );;
            return axios.get(url);
        },
        insert: (data) => {
            let url = siteUrl + '/rest/example';
            return axios.post(url, data);
        },
        update: (id, data) => {
            let url = siteUrl + '/rest/example/' + id;
            return axios.put(url, data);
        },
        delete: (id) => {
            let url = siteUrl + '/rest/example/' + id;
            return axios.delete(url);
        }
    }
}

export default exampleService;