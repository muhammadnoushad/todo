import { getLocalUser } from "./helpers/auth";

const user = getLocalUser();

export default {
    state: {
        AppTitle : 'Zero Todo App',
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null,
        todos: []
    },
    getters: {
        AppTitle(state)
        {
            return state.AppTitle;
        },
        isLoading(state) {
            return state.loading;
        },
        isLoggedIn(state) {
            return state.isLoggedIn;
        },
        currentUser(state) {
            return state.currentUser;
        },
        authError(state) {
            return state.auth_error;
        },
        todos(state) {
            return state.todos;
        }
    },
    mutations: {
        login(state) {
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload) {
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.user, {token: payload.access_token});

            localStorage.setItem("user", JSON.stringify(state.currentUser));
        },
        loginFailed(state, payload) {
            state.loading = false;
            state.auth_error = payload.error;
        },
        logout(state) {
            localStorage.removeItem("user");
            state.isLoggedIn = false;
            state.currentUser = null;
        },
        updateTodos(state, payload) {
            state.todos = payload;
        }
    },
    actions: {
        login(context) {
            context.commit("login");
        },
        getTodos(context) {
            axios.get('/api/todos')
            .then((response) => {
                context.commit('updateTodos', response.data.todos);
            })
        }
    }
};