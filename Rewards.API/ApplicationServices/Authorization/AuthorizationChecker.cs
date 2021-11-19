using System;
using System.Collections.Generic;
using System.Linq;
using System.Reflection;
using System.Text;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Rewards.API.ApplicationServices.Authorization.BaseOnAccountType;

namespace Rewards.API.ApplicationServices.Authorization
{
    public static class AuthorizationChecker
    {
        public static void CheckThatAllAPIResourcesAreProtected()
        {
            var assembly = typeof(Startup).Assembly;
            var allControllerTypes = assembly.GetTypes().Where(x => x.IsSubclassOf(typeof(ControllerBase)));

            var unProtectedActionMethods = new List<string>();
            foreach (var controllerType in allControllerTypes)
            {
                var controllerIsProtectedByAccountType = controllerType.GetCustomAttribute<AccountTypeRequirement>() != null;
                var controllerIsProtected = controllerIsProtectedByAccountType;

                if (controllerIsProtected)
                {
                    continue;
                }


                var actionMethods = controllerType.GetMethods()
                    .Where(x => x.IsPublic && x.DeclaringType == controllerType)
                    .ToList();

                foreach (var publicMethod in actionMethods)
                {
                    var hasAccountTypeRequirement = publicMethod.GetCustomAttribute<AccountTypeRequirement>();
                    var endPointIsUnguarded = hasAccountTypeRequirement == null;

                    if (endPointIsUnguarded)
                    {
                        var noPermissionRequired = publicMethod.GetCustomAttribute<AllowAnonymousAttribute>();

                        if (noPermissionRequired == null)
                        {
                            unProtectedActionMethods.Add($"{controllerType.Name}.{publicMethod.Name}");
                        }
                    }
                }
            }

            if (unProtectedActionMethods.Any())
            {
                var errorBuilder = new StringBuilder();
                errorBuilder.AppendLine("Invalid authorization configuration: ");

                foreach (var notProtectedActionMethod in unProtectedActionMethods)
                {
                    errorBuilder.AppendLine($"Method {notProtectedActionMethod} is not protected with an authorisation attribute. ");
                }

                throw new ApplicationException(errorBuilder.ToString());
            }
        }
    }
}
