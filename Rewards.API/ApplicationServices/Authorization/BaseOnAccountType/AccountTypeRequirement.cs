using System;
using Microsoft.AspNetCore.Authorization;
using Rewards.Domain.Users;

namespace Rewards.API.ApplicationServices.Authorization.BaseOnAccountType
{
    [AttributeUsage(AttributeTargets.Class | AttributeTargets.Method, AllowMultiple = false)]
    public class AccountTypeRequirement : AuthorizeAttribute
    {
        public AccountTypeRequirement(AccountType accountType)
            : base(ACCOUNT_TYPE_POLICY)
        {
            AuthorisedAccountType = accountType;
        }
        public AccountType AuthorisedAccountType { get; }

        internal const string ACCOUNT_TYPE_POLICY = "HasAccountType";
    }
}
