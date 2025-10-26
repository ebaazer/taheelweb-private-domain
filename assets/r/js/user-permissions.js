(function () {
    var baseUrl = document.getElementById("baseUrl").value;
    var rawClasses = window.rawClasses;
    //var lang = window.lang;
    var classes = rawClasses.map(function (entry) {
        return {
            id: entry.class_id,
            name: entry.name
        }
    });

    //var rawPermissions = window.rawPermissions;

    function mapPermission(rawPermission, defaultVal) {
        var permissions = [];
        Object.keys(rawPermission).forEach(function (key) {
            var val = rawPermission[key];
            //permissions[val.type] = JSON.parse(val.description);
            var rawList;
            try {
                rawList = JSON.parse(val.description);
            } catch (e) {
                console.error(e);
                rawList = {};
            }
            var list = Object.keys(rawList).map(function (key) {
                return {
                    name: key,
                    value: defaultVal != undefined ? defaultVal : rawList[key] == '1'
                }
            });

            permissions.push({
                title: val.type,
                list: list
            });
        });
        return permissions;
    }

    function mergePermissions(rawPermission, userPermission) {
        var userPermissionLookup = userPermission.reduce(function (val, entry) {
            var title = entry.title;
            entry.list.forEach(function (item) {
                val[title + "-" + item.name] = item.value;
            });
            return val;
        }, {});
        rawPermission.forEach(function (entry, typeIndex) {
            entry.list.forEach(function (item, itemIndex) {
                rawPermission[typeIndex].list[itemIndex].value = userPermissionLookup[entry.title + '-' + item.name] || false;
            });
        });
        return rawPermission;
    }

    var ractive = new Ractive({
        el: '.view',
        template: '#template',
        data: {
            classes: classes,
            employees: [],
            //permissions: permissions,
            employee: {}
        },
        langLookup: function (title) {
            return window.lang[title] || title;
        },
        rawFetch: function (url) {
            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin'
            }).then(function (response) {
                return response.json();
            }).then(function (results) {
                return results;
            })
        },
        fetchLang: function () {
            var langURL = baseUrl + "user_permission/api_permission_lang";
            this.rawFetch(langURL).then(function (lang) {
                window.lang = lang;
            })
        },

        fetchDesc: function () {
            var langURL = baseUrl + "user_permission/api_permission_desc";
            var _this = this;
            this.rawFetch(langURL).then(function (desc) {
                console.log(desc);
                _this.set('desc', desc);
            });
        },

        newEmployeeSelect: function () {
            var _this = this;
            var employee = this.get('employee');
            var userPermissionURL = baseUrl + "user_permission/api_employee_permission/" + employee.id;
            var rolePermissionURL = baseUrl + "user_permission/api_role_permission/" + employee.job_title_id;
            var rawPermissionURL = baseUrl + "user_permission/api_raw_permissions";
            Promise.all([this.rawFetch(rawPermissionURL), this.rawFetch(userPermissionURL), this.rawFetch(rolePermissionURL)]).then(
                    function (data) {
                        var rawPermission = mapPermission(data[0], false);
                        var userPermission = mapPermission(data[1]);
                        var rolePermission = mapPermission(data[2]).reduce(function (val, entry) {
                            val[entry.title] = entry.list.reduce(function (lVal, lEntry) {
                                lVal[lEntry.name] = lEntry.value;
                                return lVal;
                            }, {});
                            return val;
                        }, {});
                        var permission = mergePermissions(rawPermission, userPermission);
                        //console.log(rolePermission);
                        _this.set({
                            'rolePermission': rolePermission,
                            'permissions': rawPermission
                        })
                    })
        },
        isDisabledByRole: function (title, type) {
            var role = this.get('rolePermission');
            var permission = false;
            if (role[title]) {
                permission = role[title][type.name] == true;
            }
            //console.log(title, type.name, permission);
            return permission;
        },
        newSectionSelect: function () {
            var _this = this;
            var clazzId = this.get('clazz.id');
            var url = baseUrl + "user_permission/api_fetch_employees/" + clazzId;

            //console.log(url);

            fetch(url, {
                method: 'GET',
                credentials: 'same-origin'
            }).then(function (response) {
                return response.json();
            }).then(function (results) {
                _this.set('employees', results);
            })
        },
        showPermission: function (title, list) {
            //console.log(this.get('employee'));
            var employeeId = this.get('employee.id');

            var url = baseUrl + "user_permission/api_set_user_permission/" + employeeId;
            var description = list.reduce(function (val, entry) {
                val[entry.name] = entry.value ? "1" : "0"
                return val;
            }, {});
            var data = {
                type: title,
                description: JSON.stringify(description)
            }
            fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'content-type': 'application/json'
                },
                body: JSON.stringify(data)
            });
            toastr.warning("تم تحديث الصلاحيات");
        }
    });
    ractive.fetchLang();
    ractive.fetchDesc();
})();