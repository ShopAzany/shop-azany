using Microsoft.Extensions.Configuration;

namespace Rewards.API.ApplicationConfigurationValidators
{
    internal interface IConfigurationValidator
    {
        internal void ValidateOrThrow(IConfiguration configuration);
    }
}
