(function() {
    var baseUrl = document.getElementById("baseUrl").value;

    var rawClasses = window.rawClasses;

    var classes = rawClasses.map(function(entry) {
        return {
            id: entry.id,
            name: entry.name
        }
    });

    function mapPermission(rawPermission, defaultVal) {
        var permissions = [];
        Object.keys(rawPermission).forEach(function(key) {
            var val = rawPermission[key];
            //permissions[val.type] = JSON.parse(val.description);
            var rawList = JSON.parse(val.description);
            var list = Object.keys(rawList).map(function(key) {
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
        var userPermissionLookup = userPermission.reduce(function(val, entry) {
            var title = entry.title;
            entry.list.forEach(function(item) {
                val[title + "-" + item.name] = item.value;
            });
            return val;
        }, {});
        rawPermission.forEach(function(entry, typeIndex) {
            entry.list.forEach(function(item, itemIndex) {
                rawPermission[typeIndex].list[itemIndex].value = userPermissionLookup[entry.title +
                    '-' + item.name] || false;
            });
        });
        return rawPermission;
    }

    var ractive = new Ractive({
        el: '.view',
        template: '#template',
        data: {
            jobTitles: classes,
            employees: [],
            //permissions: permissions,
            employee: {}
        },
        langLookup: function(title) {
            return window.lang[title] || title;
        },
        rawFetch: function(url) {
            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin'
            }).then(function(response) {
                return response.json();
            }).then(function(results) {
                return results;
            })
        },
        fetchLang: function() {
            var langURL = baseUrl + "user/api_permission_lang";
            this.rawFetch(langURL).then(function(lang) {
                window.lang = lang;
            })
        },
        newEmployeeSelect: function() {
        },
        newRoleSelect: function() {
            var _this = this;
            var jobTitleId = this.get('jobTitle.id');
            var rolePermissionURL = baseUrl + "user/api_role_permission/" + jobTitleId;
            var rawPermissionURL = baseUrl + "user/api_role_raw_permissions";

            Promise.all([this.rawFetch(rawPermissionURL), this.rawFetch(rolePermissionURL)]).then(
                function(data) {
                    var rawPermission = mapPermission(data[0], false);
                    var rolePermission = mapPermission(data[1]);
                    var permission = mergePermissions(rawPermission, rolePermission);
                    _this.set('permissions', rawPermission);
                })

        },
        showPermission: function(title, list) {
            var employeeId = this.get('jobTitle.id');
            var url = baseUrl + "user/api_set_role_permission/" + employeeId;
            var description = list.reduce(function(val, entry) {
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
            })
        }
    });

    ractive.fetchLang();


})();