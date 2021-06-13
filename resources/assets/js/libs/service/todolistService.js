const todolistService = {
    data: {
        
    },
    action: {
        getTodolist: (data) => {
            let url = siteUrl + '/rest/getTodolist?' + $.param(data, true);;
            return axios.get(url);
        },
        createTodoList: (data) => {
            let url = siteUrl + '/rest/createTodoList';
            return axios.post(url, data);
        },
        updateTodoList: (id, data) => {
            let url = siteUrl + '/rest/updateTodoList/' + id;
            return axios.put(url, data);
        },
        doneTodoList: (id) => {
            let url = siteUrl + '/rest/doneTodoList/' + id;
            return axios.put(url);
        },
        deleteTodolist: (id) => {
            let url = siteUrl + '/rest/deleteTodolist/' + id;
            return axios.delete(url);
        }
    }
}

export default todolistService;