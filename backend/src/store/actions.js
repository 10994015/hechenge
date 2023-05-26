import axiosClient from "../axios";

export function login({commit}, data){
    return axiosClient.post('login', data).then(res=>{
        commit('setUser', res.data.user);
        commit('setToken', res.data.token);
        return data;
    })
}

export function logout({commit}){
    return axiosClient.post('logout').then(res=>{
        commit('setToken', null);
        return res;
    })
}
export function getUser({commit}){
    return axiosClient.get('/user').then(res=>{
        commit('setUser', res.data)
        return res;
    })
}
//article category

export function getArticleCategories({commit}, {url = null, search = '', perPage = 10, sort_field, sort_direction}){
    commit('setArticleCategories', [true]);
    url = url || '/articleCategories';
    return axiosClient.get(url, {params:{search, per_page:perPage, sort_field, sort_direction}}).then(res=>{
        commit('setArticleCategories', [false, res.data]);
    }).catch(err=>{
        commit('setArticleCategories', [false]);
    })
}
export function createArticleCategory({commit}, category){
    return axiosClient.post('/articleCategory', category);
}
export function deleteArticleCategory({commit}, id){
    return axiosClient.delete(`/articleCategory/${id}`);
}
export function deleteArticleCategoryItems({commit}, ids){
    return axiosClient.post(`/articleCategoryItems`, {'ids':ids});
}
//article
export function getArticles({commit}, {url = null, search = '', perPage = 10, sort_field, sort_direction}){
    commit('setArticles', [true]);
    url = url || '/articles';
    return axiosClient.get(url, {params:{search, per_page:perPage, sort_field, sort_direction}}).then(res=>{
        commit('setArticles', [false, res.data]);
    }).catch(err=>{
        commit('setArticles', [false]);
    })
}
export function getArticle({commit}, id){
    return axiosClient.get(`/articles/${id}`);
}
export function createArticle({commit}, article){
    const hidden = (article.hidden) ? 1 :0;
    if(article.image instanceof File){
        const form = new FormData();
        form.append('title', article.title);
        form.append('image', article.image);
        form.append('content', article.content);
        form.append('category_id', article.category_id);
        form.append('hidden', hidden);
        article = form;
    }
    return axiosClient.post('/articles', article);
}
export function isExistArticle({commit}, id){
    return axiosClient.post(`/isExistArticle`, {id: id}).then(res=>{
        return res;
    });
}
export function updateArticle({commit}, article){
    const id = article.id;
    const hidden = (article.hidden) ? 1 :0;
    if(article.image instanceof File){
        const form = new FormData();
        form.append('id', article.id);
        form.append('title', article.title);
        form.append('image', article.image);
        form.append('content', article.content);
        form.append('category_id', article.category_id);
        form.append('hidden', hidden);
        form.append('_method', 'PUT');
        article = form;
    }else{
        article._method = 'PUT'
    }
    return axiosClient.post(`/articles/${id}`, article);
}

export function deleteArticle({commit}, id){
    return axiosClient.delete(`/articles/${id}`);
}
export function deleteArticleItems({commit}, ids){
    return axiosClient.post(`/articleItems`, {'ids':ids});
}

//banners
export function getBanners({commit}, {url = null, search = '', perPage = 10, sort_field, sort_direction}){
    commit('setBanners', [true]);
    url = url || '/banners';
    return axiosClient.get(url, {params:{search, per_page:perPage, sort_field, sort_direction}}).then(res=>{
        commit('setBanners', [false, res.data]);
    }).catch(err=>{
        commit('setBanners', [false]);
    })
}
export function getBanner({commit}, id){
    return axiosClient.get(`/banners/${id}`);
}
export function createBanner({commit}, banner){
    const hidden = (banner.hidden) ? 1 :0;
    if(banner.image instanceof File){
        const form = new FormData();
        form.append('title', banner.title);
        form.append('image', banner.image);
        form.append('url', banner.url);
        form.append('hidden', hidden);
        banner = form;
    }
    return axiosClient.post('/banners', banner);
}
export function isExistBanner({commit}, id){
    return axiosClient.post(`/isExistBanner`, {id: id}).then(res=>{
        return res;
    });
}
export function updateBanner({commit}, banner){
    const id = banner.id;
    const hidden = (banner.hidden) ? 1 :0;
    if(banner.image instanceof File){
        const form = new FormData();
        form.append('id', banner.id);
        form.append('title', banner.title);
        form.append('image', banner.image);
        form.append('url', banner.url);
        form.append('hidden', hidden);
        form.append('_method', 'PUT');
        banner = form;
    }else{
        banner._method = 'PUT'
    }
    return axiosClient.post(`/banners/${id}`, banner);
}

export function deleteBanner({commit}, id){
    return axiosClient.delete(`/banners/${id}`);
}
export function deleteBannerItems({commit}, ids){
    return axiosClient.post(`/bannerItems`, {'ids':ids});
}