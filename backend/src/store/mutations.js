export function setUser(state, user){
    state.user.data = user;
}

export function setToken(state, token){
    state.user.token = token;
    if(token){
        sessionStorage.setItem('TOKEN', token);
    }else{
        sessionStorage.removeItem('TOKEN');
    }
}

export function setArticles(state, [loading, res=null]){
    if(res){
        state.articles = {
            data: res.data,
            links: res.meta.links,
            total: res.meta.total,
            limit: res.meta.per_page,
            from: res.meta.from,
            to: res.meta.to,
            page: res.meta.current_page,
        }
    }
    state.articles.loading = loading;
}

export function setArticleCategories(state, [loading, res=null]){
    if(res){
        state.articleCategories  = {
            data: res.data,
            links: res.meta.links,
            total: res.meta.total,
            limit: res.meta.per_page,
            from: res.meta.from,
            to: res.meta.to,
            page: res.meta.current_page,
        }
    }
    state.articleCategories.loading = loading;
}