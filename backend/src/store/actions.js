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
        commit('setCourses', [false]);
    })
}
export function getCourse({commit}, id){
    return axiosClient.get(`/courses/${id}`);
}
export function createCourse({commit}, course){
    const hidden = (course.hidden) ? 1 :0;
    const focus = (course.focus) ? 1 :0;
    const is_full = (course.is_full) ? 1 :0;
    if(course.image instanceof File){
        const form = new FormData();
        form.append('title', course.title);
        form.append('image', course.image);
        form.append('content', course.content);
        form.append('category_id', course.category_id);
        form.append('tags', course.tags);
        form.append('grade', course.grade);
        form.append('watched', course.watched);
        form.append('visitor', course.visitor);
        form.append('is_full', is_full);
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
    const is_full = (course.is_full) ? 1 :0;
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
        form.append('visitor', course.visitor);
        form.append('is_full', is_full);
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

//teacher category
export function getTeacherCategories({commit}, {url = null, search = '', grade = '', perPage = 10, sort_field, sort_direction}){
    commit('setTeacherCategories', [true]);
    url = url || '/teacherCategories';
    return axiosClient.get(url, {params:{search, per_page:perPage, sort_field, sort_direction, grade}}).then(res=>{
        commit('setTeacherCategories', [false, res.data]);
    }).catch(err=>{
        commit('setTeacherCategories', [false]);
    })
}
export function createTeacherCategory({commit}, category){
    return axiosClient.post('/teacherCategory', category);
}
export function deleteTeacherCategory({commit}, id){
    return axiosClient.delete(`/TeacherCategory/${id}`);
}
export function deleteTeacherCategoryItems({commit}, ids){
    return axiosClient.post(`/teacherCategoryItems`, {'ids':ids});
}

//teacher
export function getTeachers({commit}, {url = null, search = '', perPage = 10, sort_field, sort_direction, category}){
    commit('setTeachers', [true]);
    url = url || '/teachers';
    return axiosClient.get(url, {params:{search, per_page:perPage, sort_field, sort_direction, category}}).then(res=>{
        commit('setTeachers', [false, res.data]);
    }).catch(err=>{
        commit('setTeachers', [false]);
    })
}
export function getTeacher({commit}, id){
    return axiosClient.get(`/teachers/${id}`);
}
export function createTeacher({commit}, teacher){
    const hidden = (teacher.hidden) ? 1 :0;
    if(teacher.image instanceof File){
        const form = new FormData();
        form.append('name', teacher.name);
        form.append('subname', teacher.subname);
        form.append('image', teacher.image);
        form.append('title1', teacher.title1);
        form.append('content1', teacher.content1);
        form.append('title2', teacher.title2);
        form.append('content2', teacher.content2);
        form.append('title3', teacher.title3);
        form.append('content3', teacher.content3);
        form.append('title4', teacher.title4);
        form.append('content4', teacher.content4);
        form.append('title5', teacher.title5);
        form.append('content5', teacher.content5);
        form.append('category_id', teacher.category_id);
        form.append('hidden', hidden);
        teacher = form;
    }
    return axiosClient.post('/teachers', teacher);
}
export function isExistTeacher({commit}, id){
    return axiosClient.post(`/isExistTeacher`, {id: id}).then(res=>{
        return res;
    });
}
export function updateTeacher({commit}, teacher){
    const id = teacher.id;
    const hidden = (teacher.hidden) ? 1 :0;
    if(teacher.image instanceof File){
        const form = new FormData();
        form.append('id', teacher.id);
        form.append('name', teacher.name);
        form.append('subname', teacher.subname);
        form.append('image', teacher.image);
        form.append('title1', teacher.title1);
        form.append('content1', teacher.content1);
        form.append('title2', teacher.title2);
        form.append('content2', teacher.content2);
        form.append('title3', teacher.title3);
        form.append('content3', teacher.content3);
        form.append('title4', teacher.title4);
        form.append('content4', teacher.content4);
        form.append('title5', teacher.title5);
        form.append('content5', teacher.content5);
        form.append('category_id', teacher.category_id);
        form.append('hidden', hidden);
        form.append('_method', 'PUT');
        teacher = form;
    }else{
        teacher._method = 'PUT'
    }
    return axiosClient.post(`/teachers/${id}`, teacher);
}

export function deleteTeacher({commit}, id){
    return axiosClient.delete(`/teachers/${id}`);
}
export function deleteTeacherItems({commit}, ids){
    return axiosClient.post(`/teacherItems`, {'ids':ids});
}

//student
export function getStudents({commit}, {url = null, search = '', perPage = 10, sort_field, sort_direction, category}){
    commit('setStudents', [true]);
    url = url || '/students';
    return axiosClient.get(url, {params:{search, per_page:perPage, sort_field, sort_direction, category}}).then(res=>{
        commit('setStudents', [false, res.data]);
    }).catch(err=>{
        commit('setStudents', [false]);
    })
}
export function getStudent({commit}, id){
    return axiosClient.get(`/students/${id}`);
}
export function createStudent({commit}, student){
    const hidden = (student.hidden) ? 1 :0;
    if(student.image instanceof File){
        const form = new FormData();
        form.append('name', student.name);
        form.append('image', student.image);
        form.append('url', student.url);
        form.append('content', student.content);
        form.append('hidden', hidden);
        student = form;
    }
    return axiosClient.post('/students', student);
}
export function isExistStudent({commit}, id){
    return axiosClient.post(`/isExistStudent`, {id: id}).then(res=>{
        return res;
    });
}
export function updateStudent({commit}, student){
    const id = student.id;
    const hidden = (student.hidden) ? 1 :0;
    if(student.image instanceof File){
        const form = new FormData();
        form.append('id', student.id);
        form.append('name', student.name);
        form.append('image', student.image);
        form.append('url', student.url);
        form.append('content', student.content);
        form.append('hidden', hidden);
        form.append('_method', 'PUT');
        student = form;
    }else{
        student._method = 'PUT'
    }
    return axiosClient.post(`/students/${id}`, student);
}

export function deleteStudent({commit}, id){
    return axiosClient.delete(`/students/${id}`);
}
export function deleteStudentItems({commit}, ids){
    return axiosClient.post(`/studentItems`, {'ids':ids});
}

//faqs
export function getFaqs({commit}, {url = null, search = '', perPage = 10, sort_field, sort_direction, category}){
    commit('setFaqs', [true]);
    url = url || '/faqs';
    return axiosClient.get(url, {params:{search, per_page:perPage, sort_field, sort_direction, category}}).then(res=>{
        commit('setFaqs', [false, res.data]);
    }).catch(err=>{
        commit('setFaqs', [false]);
    })
}
export function getFaq({commit}, id){
    return axiosClient.get(`/faqs/${id}`);
}
export function createFaq({commit}, faq){
    const hidden = (faq.hidden) ? 1 :0;
    if(faq.image instanceof File){
        const form = new FormData();
        form.append('question', faq.question);
        form.append('content', faq.content);
        form.append('hidden', hidden);
        faq = form;
    }
    return axiosClient.post('/faqs', faq);
}
export function isExistFaq({commit}, id){
    return axiosClient.post(`/isExistFaq`, {id: id}).then(res=>{
        return res;
    });
}
export function updateFaq({commit}, faq){
    const id = faq.id;
    const hidden = (faq.hidden) ? 1 :0;
    if(faq.image instanceof File){
        const form = new FormData();
        form.append('id', faq.id);
        form.append('question', faq.question);
        form.append('content', faq.content);
        form.append('hidden', hidden);
        form.append('_method', 'PUT');
        faq = form;
    }else{
        faq._method = 'PUT'
    }
    return axiosClient.post(`/faqs/${id}`, faq);
}

export function deleteFaq({commit}, id){
    return axiosClient.delete(`/faqs/${id}`);
}
export function deleteFaqItems({commit}, ids){
    return axiosClient.post(`/faqItems`, {'ids':ids});
}

//minutes
export function getMinutes({commit}, {url = null, search = '', perPage = 10, sort_field, sort_direction}){
    commit('setMinutes', [true]);
    url = url || '/minutes';
    return axiosClient.get(url, {params:{search, per_page:perPage, sort_field, sort_direction}}).then(res=>{
        commit('setMinutes', [false, res.data]);
    }).catch(err=>{
        commit('setMinutes', [false]);
    })
}
//letters
export function getLetters({commit}, {url = null, search = '', perPage = 10, sort_field, sort_direction}){
    commit('setLetters', [true]);
    url = url || '/letters';
    return axiosClient.get(url, {params:{search, per_page:perPage, sort_field, sort_direction}}).then(res=>{
        commit('setLetters', [false, res.data]);
    }).catch(err=>{
        commit('setLetters', [false]);
    })
}
export function getLetter({commit}, id){
    return axiosClient.get(`/letters/${id}`);
}
export function isExistLetter({commit}, id){
    return axiosClient.post(`/isExistLetter`, {id: id}).then(res=>{
        return res;
    });
}
export function deleteLetter({commit}, id){
    return axiosClient.delete(`/letters/${id}`);
}
export function deleteLetterItems({commit}, ids){
    return axiosClient.post(`/letterItems`, {'ids':ids});
}
//logs
export function getLogs({commit}, {url = null, search = '', perPage = 10, sort_field, sort_direction}){
    commit('setLogs', [true]);
    url = url || '/logs';
    return axiosClient.get(url, {params:{search, per_page:perPage, sort_field, sort_direction}}).then(res=>{
        commit('setLogs', [false, res.data]);
    }).catch(err=>{
        commit('setLogs', [false]);
    })
}