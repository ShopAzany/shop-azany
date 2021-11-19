using System.Threading.Tasks;
using Microsoft.AspNetCore.Authorization;

namespace Rewards.API.ApplicationServices.Authorization.BaseOnAccountType
{
    public class AccountTypeBasedAuthorisationHandler : AuthorizationHandler<HasAccountTypeRequirement>
    {
        protected override Task HandleRequirementAsync(AuthorizationHandlerContext context, HasAccountTypeRequirement requirement)
        {
            context.Succeed(requirement);

            return Task.CompletedTask;
        }
    }
}
