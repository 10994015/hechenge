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
export function updateUser({commit}, profile){
    const id = profile.id;
    if(profile.image instanceof File){
        const form = new FormData();
        form.append('id', profile.id);
        form.append('name', profile.name);
        form.append('image', profile.image);
        form.append('_method', 'PUT');
        profile = form;
    }else{
        profile._method = 'PUT'
    }
    return axiosClient.post(`/updateUser`, profile);
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

//course category
export function getCourseCategories({commit}, {url = null, search = '', grade = '', perPage = 10, sort_field, sort_direction}){
    commit('setCourseCategories', [true]);
    url = url || '/courseCategories';
    return axiosClient.get(url, {params:{search, per_page:perPage, sort_field, sort_direction, grade}}).then(res=>{
        commit('setCourseCategories', [false, res.data]);
    }).catch(err=>{
        commit('setCourseCategories', [false]);
    })
}
export function createCourseCategory({commit}, category){
    return axiosClient.post('/courseCategory', category);
}
export function deleteCourseCategory({commit}, id){
    return axiosClient.delete(`/courseCategory/${id}`);
}
export function deleteCourseCategoryItems({commit}, ids){
    return axiosClient.post(`/courseCategoryItems`, {'ids':ids});
}
//course tag
export function getCourseTags({commit}, {url = null, search = '', perPage = 10, sort_field, sort_direction}){
    commit('setCourseTags', [true]);
    url = url || '/courseTags';
    return axiosClient.get(url, {params:{search, per_page:perPage, sort_field, sort_direction}}).then(res=>{
        commit('setCourseTags', [false, res.data]);
    }).catch(err=>{
        commit('setCourseTags', [false]);
    })
}
export function createCourseTag({commit}, category){
    return axiosClient.post('/courseTag', category);
}
export function deleteCourseTag({commit}, id){
    return axiosClient.delete(`/courseTag/${id}`);
}
export function deleteCourseTagItems({commit}, ids){
    return axiosClient.post(`/courseTagItems`, {'ids':ids});
}

//course
export function getCourses({commit}, {url = null, search = '', perPage = 10, sort_field, sort_direction}){
    commit('setCourses', [true]);
    url = url || '/courses';
    return axiosClient.get(url, {params:{search, per_page:perPage, sort_field, sort_direction}}).then(res=>{
        commit('setCourses', [false, res.data]);
    }).catch(err=>{
        commit('setCourses', [false]);s
    })
}
export function getCourse({commit}, id){
    return axiosClient.get(`/courses/${id}`);
}
export function createCourse({commit}, course){
    const hidden = (course.hidden) ? 1 :0;
    const focus = (course.focus) ? 1 :0;
    if(course.image instanceof File){
        const form = new FormData();
        form.append('title', course.title);
        form.append('image', course.image);
        form.append('content', course.content);
        form.append('category_id', course.category_id);
        form.append('tags', course.tags);
        form.append('grade', course.grade);
        form.append('watched', course.watched);
        form.append('hidden', hidden);
        form.append('focus', focus);
        course = form;
    }
    return axiosClient.post('/courses', course);
}
export function isExistCourse({commit}, id){
    return axiosClient.post(`/isExistCourse`, {id: id}).then(res=>{
        return res;
    });
}
export function updateCourse({commit}, course){
    const id = course.id;
    const hidden = (course.hidden) ? 1 :0;
    const focus = (course.focus) ? 1 :0;
    if(course.image instanceof File){
        const form = new FormData();
        form.append('id', course.id);
        form.append('title', course.title);
        form.append('image', course.image);
        form.append('content', course.content);
        form.append('category_id', course.category_id);
        form.append('tags', course.tags);
        form.append('grade', course.grade);
        form.append('watched', course.watched);
        form.append('hidden', hidden);
        form.append('focus', focus);
        form.append('_method', 'PUT');
        course = form;
    }else{
        course._method = 'PUT'
    }
    return axiosClient.post(`/courses/${id}`, course);
}

export function deleteCourse({commit}, id){
    return axiosClient.delete(`/courses/${id}`);
}
export function deleteCourseItems({commit}, ids){
    return axiosClient.post(`/courseItems`, {'ids':ids});
}