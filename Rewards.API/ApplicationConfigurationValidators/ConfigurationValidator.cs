using System;
using System.Linq;
using Microsoft.Extensions.Configuration;

namespace Rewards.API.ApplicationConfigurationValidators
{
    internal class ConfigurationValidator
    {
        internal static void RunValidators(IConfiguration configuration)
        {
            var validatorType = typeof(IConfigurationValidator);
            var validators = typeof(ConfigurationValidator)
                .Assembly.GetTypes()
                .Where(p => validatorType.IsAssignableFrom(p) && p.IsClass)
                .ToList();

            validators.ForEach(validator =>
                        (Activator.CreateInstance(validator) as IConfigurationValidator)
                        .ValidateOrThrow(configuration));
        }
    }
}
